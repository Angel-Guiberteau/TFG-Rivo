<?php

use App\Enums\MovementTypesEnum;
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

        Route::get('/getAllOperations', function(): JsonResponse {
            $data = request()->query();
            $operation = new OperationController();
            $validate = ApiValidator::validate($data, ValidationEnum::GET_OPERATIONS_OFFSET->value);

            return $operation->getAllOperationsWithLimitByAccountId($validate['data']);
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
    Route::group(['prefix' => 'icon', 'middleware' => ['auth', 'role:user']], function () {

        Route::get('/getAllIcons', function () {
            $controller = new IconController();
            return $controller->getAllIcons();
        });
    });

    Route::group(['prefix' => 'objective', 'middleware' => ['auth', 'role:user']], function () {

        Route::post('/deleteObjective/{id}', function ($id) {
            //Añadir validación del id
            $controller = new ObjectiveController();
            return $controller->deleteObjective($id);
        });

        Route::get('/getObjective/{id}', function ($id) {
            //Añadir validación del id
            $controller = new ObjectiveController();
            return $controller->getObjective($id);
        });
    });

    Route::group(['prefix' => 'category', 'middleware' => ['auth', 'role:user']], function () {

        Route::post('/delete/{id}', function ($id) {
            //Añadir validación del id
            $controller = new CategoryController();
            return $controller->deleteCategoryUser($id);
        });

        Route::get('/getCategory/{id}', function ($id) {
            //Añadir validación del id
            $controller = new CategoryController();
            return $controller->getCategory($id);
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
        // dd($data);
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

    Route::post('/addOrEditObjective', function (): RedirectResponse {
        $request = request()->toArray();

        $objectiveController = new ObjectiveController();
        
        if(is_null($request['objective_id'])){
            $request['account_id'] = session('active_account_id');
            if(!$objectiveController->addObjective($request)){
                return redirect('/home')->with('error', 'Error al añadir el objetivo. Póngase en contacto con el soporte.');
            }
            return redirect('/home')->with('success', 'Objetivo añadido correctamente');
        }else{
            if(!$objectiveController->updateObjective($request)){
                return redirect('/home')->with('error', 'Error al editar el objetivo. Póngase en contacto con el soporte.');
            }
            return redirect('/home')->with('success', 'Objetivo editado correctamente');
        }



    })->name('addOrEditObjective');

    Route::post('/addOrEditCategoryUser', function (): RedirectResponse {
        $data = request()->toArray();

        if(isset($data['types'])){
            foreach ($data['types'] as $index => $value) {
                if($value == 'income')
                    $data['types'][$index] = MovementTypesEnum::INCOME->value;
                else
                    if($value == 'expense')
                        $data['types'][$index] = MovementTypesEnum::EXPENSE->value;
                    else
                        if($value == 'save')
                            $data['types'][$index] = MovementTypesEnum::SAVEMONEY->value;
            }
        }


        $controller = new CategoryController();

        if (is_null($data['id'])) {
            $validate = BaseCategoriesValidator::validate($data, ValidationEnum::ADD->value);
            if(!$validate['status']){
                return redirect('/home')->with('error', 'Error al añadir la categoría. Póngase en contacto con el soporte.');
            }
                if (!$controller->addUserCategory($validate['data'])) {
                return redirect('/home')->with('error', 'Error al añadir la categoría. Póngase en contacto con el soporte.');
            }
            return redirect('/home')->with('success', 'Categoría añadida correctamente');

        } else {
            $validate = BaseCategoriesValidator::validate($data, ValidationEnum::EDIT->value);
            if(!$validate['status']){
                return redirect('/home')->with('error', 'Error al añadir la categoría. Póngase en contacto con el soporte.');
            }
            $validate['data']['category_id'] = $validate['data']['id'];
            if (!$controller->updateCategory($validate['data'])) {
                return redirect('/home')->with('error', 'Error al editar la categoría. Póngase en contacto con el soporte.');
            }
            return redirect('/home')->with('success', 'Categoría modificada correctamente');
        }



    })->name('addOrEditCategory');

    Route::put('/updateSettingsUser', function (): RedirectResponse {

        $request = request()->toArray();
        $request['id'] = Auth::user()->id;
        // dd($request);
        $validate = UserValidator::validate($request, ValidationEnum::EDIT->value);

        if(!$validate['status']){
            return redirect()->back()->with('error', 'Error al actualizar el usuario. Póngase en contacto con el soporte.');
        }
        // dd($validate);
        return UserController::updateUser($validate['data']);

    })->name('updateSettingsUser');
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

    // ============= Usuarios =============

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', function (): View {
            return UserController::listUsers();
        })->name('users');

        Route::get('/addUser', function (): View {
            return view('admin.users.addUser');
        })->name('addUser');

        Route::post('/storeUser', function (): RedirectResponse {

            $request = request()->toArray();

            $validate = UserValidator::validate($request, ValidationEnum::ADD->value);
            
            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al añadir el usuario. Póngase en contacto con el soporte.');
            }

            return UserController::storeUser($validate);

        })->name('storeUser');

        Route::post('/deleteUser', function (): RedirectResponse {
            $request = request()->toArray();

            $validate = UserValidator::validate($request, ValidationEnum::DELETE->value);
            
            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al eliminar el usuario. Póngase en contacto con el soporte.');
            }

            return UserController::deleteUser($validate['data']);
        })->name('deleteUser');

        Route::get('/editUser/{id}', function ($id): RedirectResponse|View {
            $request = request()->toArray();

            $validate = UserValidator::validate($request, ValidationEnum::DELETE->value);
            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al editar el obtener los datos del usuario. Póngase en contacto con el soporte.');
            }

            $si = UserController::getUserbyId(['id' => $id]);
            dd($si);
        })->name('editUser');

        Route::put('/updateUser', function (): RedirectResponse {

            $request = request()->toArray();
            
            $validate = UserValidator::validate($request, ValidationEnum::EDIT->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al actualizar el usuario. Póngase en contacto con el soporte.');
            }

            return UserController::updateUser($validate['data']);

        })->name('updateUser');


        Route::put('/updatePersonalCategories', function () {

            $request = request()->toArray();
            
            $validate = UserValidator::validate($request, ValidationEnum::UPDATE_PERSONAL_CATEGORIES->value);
            
            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al actualizar las categorías personales. Póngase en contacto con el soporte.');
            }

            return UserController::updatePersonalCategories($validate);

        })->name('updatePersonalCategories');

        Route::put('/updatePersonalAccounts', function () {

            $request = request()->toArray();

            $validate = UserValidator::validate($request, ValidationEnum::UPDATE_PERSONAL_ACOUNTS->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al actualizar las cuentas personales. Póngase en contacto con el soporte.');
            }

            return UserController::updatePersonalAccounts($validate);

        })->name('updatePersonalAccounts');

        Route::get('/previewUser/{id}', function (Request $request, $id) {


            $request = array_merge($request->all(), ['id' => $id]);

            $validate = UserValidator::validate($request, ValidationEnum::DELETE->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al previsualizar el usuario. Póngase en contacto con el soporte.');
            }

            return UserController::getFullUserbyId($validate );

        })->name('previewUser');

    });

    // ============= Frases =============

    Route::group(['prefix' => 'sentences'], function () {
        Route::get('/', function (): View {
            return SentenceController::listSentences();
        })->name('sentences');

        Route::post('/add', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = SentencesValidator::validate($data, ValidationEnum::ADD->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al añadir la frase. Póngase en contacto con el soporte.');
            }

            return SentenceController::addSentence($validate);
        })->name('addSentence');

        Route::put('/edit', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = SentencesValidator::validate($data, ValidationEnum::EDIT->value);

            return SentenceController::editSentence($validate);
        })->name('editSentence');

        Route::post('/delete', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = SentencesValidator::validate($data, ValidationEnum::DELETE->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al eliminar la frase. Póngase en contacto con el soporte.');
            }

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

    // ============= Categorias =============

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

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al añadir la categoría. Póngase en contacto con el soporte.');
            }

            return BaseCategoryController::addBaseCategory($validate);
        })->name('addCategory');

        Route::put('/edit', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = BaseCategoriesValidator::validate($data, ValidationEnum::EDIT->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al editar la categoría. Póngase en contacto con el soporte.');
            }

            return BaseCategoryController::editBaseCategory($validate);
        })->name('editCategory');

        Route::post('/delete', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = CategoriesValidator::validate($data, ValidationEnum::DELETE->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al eliminar la categoría. Póngase en contacto con el soporte.');
            }

            return CategoryController::deleteCategory($validate);
        })->name('deleteCategory');
    });

    // ============= Iconos =============  

    Route::group(['prefix' => 'icons'], function () {
        Route::get('/', function (): View {

            $icons = IconController::getAllIcons();

            return view('admin.icons.icons')
                ->with('icons', $icons);
        })->name('icons');

        Route::post('/add', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = IconValidator::validate($data, ValidationEnum::ADD->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al añadir el icono. Póngase en contacto con el soporte.');
            }

            return IconController::addIcon($validate);
        })->name('addIcon');

        Route::put('/edit', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = IconValidator::validate($data, ValidationEnum::EDIT->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al editar el icono. Póngase en contacto con el soporte.');
            }

            return IconController::editIcon($validate);
        })->name('editIcon');

        Route::post('/delete', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = IconValidator::validate($data, ValidationEnum::DELETE->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al eliminar el icono. Póngase en contacto con el soporte.');
            }

            return IconController::deleteIcon($validate);
        })->name('deleteIcon');
    });

    // ============= EndPoints =============  

    Route::group(['prefix' => 'endPoints'], function () {
        Route::get('/', function (): View {
            $data = EndPointController::getAllEnabledEndPoints();
            return view('admin.endPoints.endPoint')->with('endPoints', $data);
        })->name('endPoints');

        Route::get('/add', function (): View {
            return view('admin.endPoints.addEndpoint');
        })->name('addEndPoints');

        Route::post('/safeEndpoint', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = EndPointValidator::validate($data, ValidationEnum::ADD->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al añadir el endpoint. Póngase en contacto con el soporte.');
            }

            return EndPointController::addEndPoint($validate);
        })->name('safeEndPoint');

        Route::get('/edit/{id}', function ($id): View {
            $data = EndPointController::getEndPointById($id);

            return view('admin.endPoints.editEndpoint')->with('endPoint',$data);
        })->name('editEndPoint');

        Route::put('/safeEditeEndPoint', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = EndPointValidator::validate($data, ValidationEnum::EDIT->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al editar el endpoint. Póngase en contacto con el soporte.');
            }

            return EndPointController::editEndPoint($validate);
        })->name('safeEditEndPoints');

        Route::post('/delete', function (): RedirectResponse {
            $data = request()->toArray();

            $validate = EndPointValidator::validate($data, ValidationEnum::DELETE->value);

            if(!$validate['status']){
                return redirect()->back()->with('error', $validate['error'] ?? 'Error al eliminar el endpoint. Póngase en contacto con el soporte.');
            }

            return EndPointController::deleteEndPoint($validate);
        })->name('deleteEndPoints');

    });
});

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/
