<?php

use App\Enums\ValidationEnum;
use App\Http\Controllers\BaseCategoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IconController;
use App\Models\BaseCategory;
use App\Models\Icons;
use App\Validations\BaseCategoriesValidator;
use App\Validations\SentencesValidator;
use App\Validations\CategoriesValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;
use App\Validations\UserValidator;
use App\Validations\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Js;


/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/', function () {
    return view('auth.login_register');
});

Route::get('/home', function (): View {
    
    $userController = new UserController();
    $user = $userController->getUser();

    $accountController = new AccountController();
    $account = $accountController->getAccountByUserId($user->id);

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
        ->with('objectives', $objective);

})->middleware(['auth', 'role:user'])->name('home');

Route::get('/initialSetup', function () {
    return view('home.initialSetup');
})->middleware(['auth', 'role:user'])->name('initialSetup');

Route::post('/updateUserInfoFromInitialSetup', function () {

    $request = Request()->all();

    $validate = UserValidator::validate($request, ValidationEnum::INITIALSETUP->value);
    $data = $validate['data'];
    $controller = new UserController();

    return  $controller->updateUserInfoFromInitialSetup($data);
    
})->middleware(['auth', 'role:user'])->name('updateUserInfoFromInitialSetup');


/*
|--------------------------------------------------------------------------
| Google Login/Register Routes
|--------------------------------------------------------------------------
*/

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



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    
    Route::get('/', function (): View {
        return view('admin.home.home');
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
            // dd(request()->all());
            
            $request = request()->toArray();    

            $validate = UserValidator::validate($request, ValidationEnum::UPDATE_PERSONAL_CATEGORIES->value);
            
            return UserController::updatePersonalCategories($validate);
        })->name('updatePersonalCategories');

        Route::put('/updatePersonalAccounts', function () {

            dd(request()->all());
            
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
            $data = [
                'text' => request()->input('name')
            ];
            $validate = SentencesValidator::validate($data, ValidationEnum::ADD->value);
            return SentenceController::addSentence($validate);
        })->name('addSentence');

        Route::put('/edit', function (): RedirectResponse {
            $data = [
                'id' => request()->input('id'),
                'text' => request()->input('text')
            ];
            $validate = SentencesValidator::validate($data, ValidationEnum::EDIT->value);
            return SentenceController::editSentence($validate);
        })->name('editSentence');

        Route::post('/delete', function (): JsonResponse {
            $data = [
                'id' => request('id')
            ];
            $validate = SentencesValidator::validate($data, ValidationEnum::DELETE->value);

            return SentenceController::deleteSentence($validate);
        })->name('deleteSentence');

        Route::post('/preViewSentence', function (): View {
            $data = [
                'text' => request('text')
            ];
            // $validate = SentencesValidator::validate($data, ValidationEnum::PREVIEW->value);
            // return view('admin.sentences.preViewSentence')->with('sentence', $validate['text']);
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
            return view('admin.categories.categories')
                ->with('categories', $baseCategories)
                ->with('icons', $icons);
        })->name('categories');

        Route::post('/add', function (): RedirectResponse {
            $data = [
                'name' => request()->input('name'),
                'types' => request()->input('types'),
                'iconId' => request()->input('icon'),
            ];
            $validate = BaseCategoriesValidator::validate($data, ValidationEnum::ADD->value);
            return BaseCategoryController::addBaseCategory($validate);
        })->name('addCategory');

        Route::put('/edit', function (): RedirectResponse {
            $data = [
                'id' => request()->input('id'),
                'name' => request()->input('name'),
                'types' => request()->input('types'),
                'iconId' => request()->input('icon'),
            ];
            $validate = BaseCategoriesValidator::validate($data, ValidationEnum::EDIT->value);
            return BaseCategoryController::editBaseCategory($validate);
        })->name('editCategory');

        Route::post('/delete', function (): JsonResponse {
            $data = [
                'id' => request('id')
            ];
            $validate = CategoriesValidator::validate($data, ValidationEnum::DELETE->value);

            return CategoryController::deleteCategory($validate);
        })->name('deleteCategory');
    });
    
});




/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/
