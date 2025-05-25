<?php

use App\Enums\ValidationEnum;
use App\Http\Controllers\CategoryController;
use App\Validations\SentencesValidator;
use App\Validations\CategoriesValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\SentenceController;
use App\Http\Controllers\UserController;

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
    return view('home.home')->with('user', $user);
})->middleware(['auth', 'role:user'])->name('home');

Route::get('/initialSetup', function () {
    return view('home.initialSetup');
})->middleware(['auth', 'role:user'])->name('initialSetup');
Route::post('/updateUserInfo', function () {
    $request = Request();

    $controller = new UserController();
    return  $controller->updateUserInfo($request);
})->middleware(['auth', 'role:user'])->name('updateUserInfo');


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
    
    Route::get('/', function () {
        return view('admin.home.home');
    })->name('homeAdmin');

                                // USERS

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', function () {
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

        Route::get('/editUser/{id}', function ($id) {
            return UserController::getUserbyId($id);
        })->name('editUser');

        Route::put('/updateUser', function (): RedirectResponse {
            return UserController::updateUser();
        })->name('updateUser');

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
            return CategoryController::listCategories();
        })->name('categories');

        Route::post('/add', function (): RedirectResponse {
            $data = [
                'name' => request()->input('name')
            ];
            $validate = CategoriesValidator::validate($data, ValidationEnum::ADD->value);
            return CategoryController::addCategory($validate);
        })->name('addCategory');

        Route::put('/edit', function (): RedirectResponse {
            $data = [
                'id' => request()->input('id'),
                'name' => request()->input('name')
            ];
            $validate = CategoriesValidator::validate($data, ValidationEnum::EDIT->value);
            return CategoryController::editCategory($validate);
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
