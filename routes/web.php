<?php

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\SentenceController;

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

Route::get('/home', function () {
    return view('home.home');
})->middleware(['auth', 'role:user'])->name('home');


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

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', function () {
            return view('admin.users.users');
        })->name('users');
    });

    Route::group(['prefix' => 'sentences'], function () {
        Route::get('/', function (): View {
            return SentenceController::listSentences();
        })->name('sentences');

        Route::post('/add', function (): RedirectResponse {
            return SentenceController::addSentence(request()->input('name'));
        })->name('addSentence');

        Route::put('/edit', function (): RedirectResponse {
            $data = [
                'id' => request()->input('id'),
                'text' => request()->input('text')
            ];
            return SentenceController::editSentence($data);
        })->name('editSentence');

        Route::post('/deleteSentence', function (): JsonResponse {
            $data = ['id' => request('id')];
            return SentenceController::deleteSentence($data);
        })->name('deleteSentence');

        Route::post('/preViewSentence', function (): View {
            $data = request('text');
            return view('admin.sentences.preViewSentence')->with('sentence', $data);
        })->name('preViewSentence');

        Route::get('/mockups', function (): View {
            return view('admin.mockups.adminSentences');
        })->name('sentenceMockups');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', function () {
            return view('admin.categories.categories');
        })->name('categories');
    });
    
});