<?php

use App\Enums\ValidationEnum;
use App\Http\Controllers\BaseCategoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EndPointController;
use App\Http\Controllers\IconController;
use App\Models\BaseCategory;
use App\Models\Icons;
use App\Validations\ApiValidator;
use App\Validations\BaseCategoriesValidator;
use App\Validations\EndPointValidator;
use App\Validations\IconValidator;
use App\Validations\SentencesValidator;
use App\Validations\CategoriesValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;
use App\Validations\UserValidator;
use App\Validations\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Js;




/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api', 'middleware' => ['auth', 'role:user']], function () {
    // Operation
    Route::group(['prefix' => 'operation', 'middleware' => ['auth', 'role:user']], function () {
        Route::get('/transaction/{id}', function ($id): JsonResponse {
            $operation = new OperationController();
            $data = [
                'id' => $id,
            ];
            $validate = ApiValidator::validate($data, ValidationEnum::GET_OPERATION_BY_ID->value);

            return $operation->getOperationById($validate['data']['id']);
        });

        Route::get('/incomeOperations', function(): JsonResponse {
            $data = request()->toArray();
            $operation = new OperationController();
            $validate = ApiValidator::validate($data, ValidationEnum::GET_OPERATIONS_OFFSET->value);

            return $operation->incomeOperations($validate['data']);
        });

        Route::get('/expenseOperations', function(): JsonResponse {
            $data = request()->toArray();
            $operation = new OperationController();
            $validate = ApiValidator::validate($data, ValidationEnum::GET_OPERATIONS_OFFSET->value);

            return $operation->expenseOperations($validate['data']);
        });

        Route::get('/saveOperations', function(): JsonResponse {
            $data = request()->toArray();
            $operation = new OperationController();
            $validate = ApiValidator::validate($data, ValidationEnum::GET_OPERATIONS_OFFSET->value);

            return $operation->saveOperations($validate['data']);
        });
        
        Route::post('/deleteOperation/{id}', function($id): JsonResponse {
            $operation = new OperationController();
            $data = [
                'id' => $id,
            ];
            $validate = ApiValidator::validate($data, ValidationEnum::DELETE_OPERATION->value);

            return $operation->deleteOperation($validate['data']['id']);
        });

        Route::get('/refreshRecentOperations', function () {
            $accountId = session('active_account_id');
            $controller = new OperationController();
            return $controller->getSixOperationsByAccountId($accountId);
        });
    });
});

/*
|--------------------------------------------------------------------------
| Google Login/Register Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login_register');
});

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');
    
Route::get('/auth/google/callback', function () {

    $controller = new GoogleController();
    return $controller->handleGoogleCallback();

});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/




Route::group(['middleware' => ['auth', 'role:user']], function () {
    
    Route::get('/home', function (): View {
    
        $userController = new UserController();
        $user = $userController->getUser();

        $accountController = new AccountController();
        $account = $accountController->getAccountByUserId($user->id);

        Session::put('active_account_id', $account->id);

        $objectiveController = new ObjectiveController();
        $objective =$objectiveController->getObjectivesByAccountId($account->id);

        $operationController = new OperationController();
        $sixOperations = $operationController->getSixOperationsByAccountId($account->id);

        $thisMonthOperations = $operationController->thisMonthOperationsByAccountId($account->id);
        $incomes = $thisMonthOperations->filter(function ($op) {
            return $op['movement_type_id'] === 1;
        });

        $expenses = $thisMonthOperations->filter(function ($op) {
            return in_array($op['movement_type_id'], [2]);
        });

        $categoryController = new CategoryController();
        $baseCategories = $categoryController->getAllBaseCategories();
        $personalCategories = $categoryController->getPersonalCategoriesByUserId($user->id);
        


        $allIncomes = $operationController->getAllIncomesByAccountId($account->id);
        $allExpenses = $operationController->getAllIncomesByAccountId($account->id);

        return view('home.home')
            ->with('user', $user)
            ->with('account', $account)
            ->with('sixOperations', $sixOperations)
            ->with('thisMonthOperations', $thisMonthOperations)
            ->with('thisMonthIncomes', $incomes)
            ->with('thisMonthExpenses', $expenses)
            ->with('allIncomes', $allIncomes)
            ->with('allExpenses', $allExpenses)
            ->with('baseCategories', $baseCategories)
            ->with('personalCategories', $personalCategories)
            ->with('objectives', $objective);

    })->name('home');

    Route::post('/updateUserInfoFromInitialSetup', function () {

        $request = Request()->all();

        $validate = UserValidator::validate($request, ValidationEnum::INITIALSETUP->value);
        $data = $validate['data'];
        $controller = new UserController();

        return  $controller->updateUserInfoFromInitialSetup($data);
        
    })->name('updateUserInfoFromInitialSetup');

    Route::get('/initialSetup', function () {
        return view('home.initialSetup');
    })->name('initialSetup');
    
    Route::post('/addOperationUser', function () {
        $request = request()->toArray();
        if (!isset($request['schedule']) || $request['schedule'] !== 'on') {
            unset($request['expiration_date'], $request['recurrence']);
        }
        
        $validate = UserValidator::validate($request, ValidationEnum::ADD_OPERATION_USER->value);
        if(!$validate['status']){
            return redirect('/home')->with('error', 'Error al hacer la operación. Póngase en contacto con el soporte.');
        }
        
        $data = $validate['data'];
        $data['account_id'] = session('active_account_id');
        $operationController = new OperationController();
        $operationController->movement_type = $data['movement_type'];
        if(!$operationController->addOperationRequested($data)){
            return redirect('/home')->with('error', 'Error al hacer la operación. Póngase en contacto con el soporte.');
        }
        
        return redirect('/home')->with('success', 'Operación añadida correctamente');


    })->name('addOperationUser');
    
    Route::post('/addObjective', function () {
        //Le llega el nombre del objetivo y el dinero objetivo.
        $request = request()->toArray();
        
        $request['account_id'] = session('active_account_id');
        $objectiveController = new ObjectiveController();
        if(!$objectiveController->addObjective($request)){
            return redirect('/home')->with('error', 'Error al añadir el objetivo. Póngase en contacto con el soporte.');
        }
        
        return redirect('/home')->with('success', 'Operación añadida correctamente');


    })->name('addObjective');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    
    Route::get('/', function (): View {

        $numUsers = UserController::numberOfUsers();
        $numSentences = SentenceController::numberOfSentences();
        $numIcons = IconController::numberOfIcons();
        $numCategory = CategoryController::numberOfCategories();

        return view('admin.home.home')
            ->with('numUsers', $numUsers)
            ->with('numSentences', $numSentences)
            ->with('numIcons', $numIcons)
            ->with('numCategory', $numCategory);
    })->name('homeAdmin');

    // USERS

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', function (): View {

            return UserController::listUsers();
        })->name('users');

        Route::get('/addUser', function (): View {
            return view('admin.users.addUser');
        })->name('addUser');

        Route::post('/storeUser', function (): RedirectResponse {
            return UserController::storeUser();
        })->name('storeUser');

        Route::post('/deleteUser', function (): JsonResponse {
            return UserController::deleteUser();
        })->name('deleteUser');

        Route::get('/editUser/{id}', function ($id): RedirectResponse|View {
            return UserController::getUserbyId($id);
        })->name('editUser');

        Route::put('/updateUser', function (): RedirectResponse {
            return UserController::updateUser();
        })->name('updateUser');

        Route::put('/updatePersonalCategories', function () {
            
            $request = request()->toArray();    
            // dd($request);
            $validate = UserValidator::validate($request, ValidationEnum::UPDATE_PERSONAL_CATEGORIES->value);
            // dd($validate);
            return UserController::updatePersonalCategories($validate);

        })->name('updatePersonalCategories');

        Route::put('/updatePersonalAccounts', function () {

            $request = request()->toArray();

            // dd($request);

            $validate = UserValidator::validate($request, ValidationEnum::UPDATE_PERSONAL_ACOUNTS->value);

            return UserController::updatePersonalAccounts($validate);
            
        })->name('updatePersonalAccounts');

        Route::get('/previewUser/{id}', function (Request $request, $id) {

            
            $request = array_merge($request->all(), ['id' => $id]);
            
            $validate = UserValidator::validate($request, ValidationEnum::DELETE->value);
            
            return UserController::getFullUserbyId($validate );

        })->name('previewUser');

    });

                                // SENTENCES

    Route::group(['prefix' => 'sentences'], function () {
        Route::get('/', function (): View {
            return SentenceController::listSentences();
        })->name('sentences');

        Route::post('/add', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = SentencesValidator::validate($data, ValidationEnum::ADD->value);
            
            return SentenceController::addSentence($validate);
        })->name('addSentence');

        Route::put('/edit', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = SentencesValidator::validate($data, ValidationEnum::EDIT->value);

            return SentenceController::editSentence($validate);
        })->name('editSentence');

        Route::post('/delete', function (): JsonResponse {
            $data = request()->toArray();

            $validate = SentencesValidator::validate($data, ValidationEnum::DELETE->value);

            return SentenceController::deleteSentence($validate);
        })->name('deleteSentence');

        Route::post('/preViewSentence', function (): View {
            $data = request()->toArray();
            
            return view('admin.sentences.preViewSentence')->with('sentence', $data['text']);
        })->name('preViewSentence');

        Route::get('/mockups', function (): View {
            return view('admin.mockups.adminSentences');
        })->name('sentenceMockups');
    });
    
                                // CATEGORIES

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', function (): View {
            $baseCategories = BaseCategoryController::listAllBaseCategories();
            $icons = IconController::getAllIcons();
            $movementTypes = CategoryController::getEnabledMovementTypes();

            return view('admin.categories.categories')
                ->with('categories', $baseCategories)
                ->with('icons', $icons)
                ->with('movementTypes', $movementTypes);

        })->name('categories');

        Route::post('/add', function (): RedirectResponse {
            $data = request()->toArray();
            
            $validate = BaseCategoriesValidator::validate($data, ValidationEnum::ADD->value);

            return BaseCategoryController::addBaseCategory($validate);
        })->name('addCategory');

        Route::put('/edit', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = BaseCategoriesValidator::validate($data, ValidationEnum::EDIT->value);

            return BaseCategoryController::editBaseCategory($validate);
        })->name('editCategory');

        Route::post('/delete', function (): JsonResponse {
            $data = request()->toArray();

            $validate = CategoriesValidator::validate($data, ValidationEnum::DELETE->value);

            return CategoryController::deleteCategory($validate);
        })->name('deleteCategory');
    });
    
                                // Icons

    Route::group(['prefix' => 'icons'], function () {
        Route::get('/', function (): View {
            
            $icons = IconController::getAllIcons();

            return view('admin.icons.icons')
                ->with('icons', $icons);
        })->name('icons');

        Route::post('/add', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = IconValidator::validate($data, ValidationEnum::ADD->value);

            return IconController::addIcon($validate);
        })->name('addIcon');

        Route::put('/edit', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = IconValidator::validate($data, ValidationEnum::EDIT->value);

            return IconController::editIcon($validate);
        })->name('editIcon');

        Route::post('/delete', function (): JsonResponse {
            $data = request()->toArray();
            
            $validate = IconValidator::validate($data, ValidationEnum::DELETE->value);

            return IconController::deleteIcon($validate);
        })->name('deleteIcon');
    });

                                // EndPoints

    Route::group(['prefix' => 'endPoints'], function () {
        Route::get('/', function (): View {
            $data = EndPointController::getAllEnabledEndPoints();
            return view('admin.endPoints.endPoint')->with('endPoints', $data);
        })->name('endPoints');

        Route::get('/add', function (): View {
            return view('admin.endPoints.addEndpoint');
        })->name('addEndPoints');

        Route::post('/safeEndpoint', function (): JsonResponse {
            $data = request()->toArray();

            $validate = EndPointValidator::validate($data, ValidationEnum::ADD->value);

            return EndPointController::addEndPoint($validate);
        })->name('safeEndPoint');

        Route::get('/edit/{id}', function ($id): View {
            $data = EndPointController::getEndPointById($id);

            return view('admin.endPoints.editEndpoint')->with('endPoint',$data);
        })->name('editEndPoint');

        Route::put('/safeEditeEndPoint', function (): JsonResponse {
            $data = request()->toArray();
            
            $validate = EndPointValidator::validate($data, ValidationEnum::EDIT->value);
            
            return EndPointController::editEndPoint($validate);
        })->name('safeEditEndPoints');

        Route::post('/delete', function (): JsonResponse {
            $data = request()->toArray();

            $validate = EndPointValidator::validate($data, ValidationEnum::DELETE->value);

            return EndPointController::deleteEndPoint($validate);
        })->name('deleteEndPoints');
        
    });
});




/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/
