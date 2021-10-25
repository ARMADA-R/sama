<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





// Headmaster

Route::group([
    'prefix' => 'headmaster',
    'middleware' => ['defineGuard:headmaster'], //, 'AuthenticateAdminsSession'
],  function () {
    Config::set('auth.defines', 'headmaster');



    // login routes
    Route::get('login', [App\Http\Controllers\Headmaster\Auth\LoginController::class, "showLoginForm"])->name('headmaster.login');
    Route::post('login', [App\Http\Controllers\Headmaster\Auth\LoginController::class, "login"]);

    //forgot password Routes
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('headmaster.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('headmaster.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('headmaster.password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('headmaster.password.update');



    Route::group(['middleware' => ['headmasters:headmaster']], function () {

        // email verifiction routes
        Route::get('email/verify', 'Auth\VerificationController@show')->name('headmaster.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('headmaster.verification.verify');
        Route::post('email/resend', 'Auth\VerificationController@resend')->name('headmaster.verification.resend');

        //headmaster logout route
        Route::post('logout', [App\Http\Controllers\Headmaster\Auth\LoginController::class, "logout"])->name('headmaster.logout');

        //closed account route
        Route::get('account/closed', 'UsersManagerController@ShowClosedAccountView')->name('headmaster.closedAccount');

        Route::group(['middleware' => []], function () {

            Route::get('/', function () {
                return view('headmaster.home');
            })->name('headmaster.home');
        });
    });
});




// Guidance
Route::group([
    'prefix' => 'guidance',
    'middleware' => ['defineGuard:guidance'], //, 'AuthenticateAdminsSession'
],  function () {
    Config::set('auth.defines', 'guidance');

    // login routes
    Route::get('login', [App\Http\Controllers\Guidance\Auth\LoginController::class, "showLoginForm"])->name('guidance.login');
    Route::post('login', [App\Http\Controllers\Guidance\Auth\LoginController::class, "login"]);

    //forgot password Routes
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('guidance.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('guidance.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('guidance.password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('guidance.password.update');


    Route::group(['middleware' => ['guidance:guidance']], function () {

        // email verifiction routes
        Route::get('email/verify', 'Auth\VerificationController@show')->name('guidance.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('guidance.verification.verify');
        Route::post('email/resend', 'Auth\VerificationController@resend')->name('guidance.verification.resend');

        //guidance logout route
        Route::post('logout', [App\Http\Controllers\Guidance\Auth\LoginController::class, "logout"])->name('guidance.logout');

        //closed account route
        Route::get('account/closed', 'UsersManagerController@ShowClosedAccountView')->name('guidance.closedAccount');
        
        Route::group(['middleware' => []], function () {
            
            Route::get('workpaper', [App\Http\Controllers\Guidance\LoginController::class, "logout"])->name('guidance.workPaper');


            Route::get('/', function () {
                return view('guidance.home');
            })->name('guidance.home');
        });
    });
});
