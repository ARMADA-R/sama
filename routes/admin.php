<?php

use Illuminate\Support\Facades\Config;
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


// Auth::routes();


Route::group([
    'prefix' => 'admin',
    'middleware' => ['defineAdmin'],//, 'AuthenticateAdminsSession'
],  function () {
    Config::set('auth.defines', 'admin');


    // Route::get('/', function () {
    //     return view('admin.home');
    // });

    // Route::get('Support', 'AdminsManagerController@support')->name('admin.ContactSupport');

    // login routes
    Route::get('login', [App\Http\Controllers\Admin\Auth\LoginController::class, "showLoginForm"])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Admin\Auth\LoginController::class, "login"]);

    //register new admin routes
    // Route::get('register/{token}/{email}', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
    // Route::post('register', 'Auth\RegisterController@register');

    //forgot password Routes
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');

    Route::group(['middleware' => ['admins:admin']], function () {

        Route::get('/', function () {
            return view('admin.home');
        });
        // email verifiction routes
        Route::get('email/verify', 'Auth\VerificationController@show')->name('admin.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('admin.verification.verify');
        Route::post('email/resend', 'Auth\VerificationController@resend')->name('admin.verification.resend');


        //admin logout route
        Route::post('logout', [App\Http\Controllers\Admin\Auth\LoginController::class, "logout"])->name('admin.logout');

        //closed account route
        Route::get('account/closed', 'UsersManagerController@ShowClosedAccountView')->name('admin.closedAccount');


        Route::group(['middleware' => []], function () {

            //admin definition routes
            Route::get('define', 'Auth\RegisterController@showAdminDefinitionForm')->name('admin.define');
            Route::post('define', 'Auth\RegisterController@invitation');

            Route::get('users', [App\Http\Controllers\Admin\UsersController::class, "users"])->name('admin.users');;
            Route::get('users/create', [App\Http\Controllers\Admin\UsersController::class, "showCreateAdminView"])->name('admin.users.create');
            Route::post('users/create', [App\Http\Controllers\Admin\UsersController::class, "create"]);
            Route::get('users/edit/{id}', [App\Http\Controllers\Admin\UsersController::class, "showUpdateAdminView"])->name('admin.users.update');
            Route::post('users/edit/{id}', [App\Http\Controllers\Admin\UsersController::class, "update"]);
            Route::post('users/edit/{id}/password', [App\Http\Controllers\Admin\UsersController::class, "updatePassword"])->name('admin.users.update.password');
            Route::post('users/edit/{id}/status', [App\Http\Controllers\Admin\UsersController::class, "updateAccountStatus"])->name('admin.users.update.status');
            

            

            Route::get('students', [App\Http\Controllers\Admin\StudentsController::class, "students"])->name('admin.students');;
            // Route::get('users/create', [App\Http\Controllers\Admin\StudentsController::class, "showCreateAdminView"])->name('admin.users.create');
            // Route::post('users/create', [App\Http\Controllers\Admin\StudentsController::class, "create"]);
            // Route::get('users/edit/{id}', [App\Http\Controllers\Admin\StudentsController::class, "showUpdateAdminView"])->name('admin.users.update');
            // Route::post('users/edit/{id}', [App\Http\Controllers\Admin\StudentsController::class, "update"]);
            // Route::post('users/edit/{id}/password', [App\Http\Controllers\Admin\StudentsController::class, "updatePassword"])->name('admin.users.update.password');
            // Route::post('users/edit/{id}/status', [App\Http\Controllers\Admin\StudentsController::class, "updateAccountStatus"])->name('admin.users.update.status');
            


            // Route::get('users/account/details/{id}', 'UsersManagerController@accountDetails')->name('admin.UserAccountDetails');
            // Route::get('users/account/edit/{id}', 'UsersManagerController@editAcountGET')->name('admin.UsersAccountEdit');
            // Route::post('users/account/edit', 'UsersManagerController@editAcountPOST')->name('admin.updateAccountDetails');
            // Route::post('users/account/edit/password', 'UsersManagerController@UpdateAcountPassword')->name('admin.updateAccountPassword');
            // Route::post('account/close', 'UsersManagerController@closeAccount')->name('admin.CloseUserAccount');
            // Route::post('account/update/avatar', 'UsersManagerController@updateAvatar')->name('admin.updateAccountAvatar');
            // Route::post('account/activate', 'UsersManagerController@activateAccount')->name('admin.ActivateUserAccount');
            // Route::get('user-data', 'UsersManagerController@getCustomFilterData');

            Route::get('languages', 'LanguagesManagerController@languages')->name('admin.languages');
            Route::get('languages/details/{id}', 'LanguagesManagerController@languagesDetails')->name('admin.languageDetails');
            Route::get('languages/edit/{id}', 'LanguagesManagerController@languageEditGET')->name('admin.languageEdit');
            Route::post('languages/edit', 'LanguagesManagerController@languageEditPOST')->name('admin.languageEditPOST');

            Route::get('languages/create', 'LanguagesManagerController@addLanguage')->name('admin.languageAdd');
            Route::post('language/define', 'LanguagesManagerController@defineNewLanguage')->name('admin.defineLanguage');

            Route::get('files/manage', 'FilesManagerController@show')->name('admin.manageFiles');

            Route::get('roles', [App\Http\Controllers\Admin\RolesController::class, "roles"])->name('admin.roles');
            Route::get('roles/create', [App\Http\Controllers\Admin\RolesController::class, "showCreateRoleView"])->name('admin.roles.create');
            Route::post('roles/create', [App\Http\Controllers\Admin\RolesController::class, "create"]);
            Route::post('roles/delete', [App\Http\Controllers\Admin\RolesController::class, "delete"])->name('admin.roles.delete');
            Route::get('roles/update/{id}', [App\Http\Controllers\Admin\RolesController::class, "showUpdateForm"])->name('admin.roles.update');
            Route::post('roles/update/{id}', [App\Http\Controllers\Admin\RolesController::class, "update"]);

            // Route::get('roles/details/{id}', 'RolesController@details')->name('admin.roleDetails');
            // Route::get('roles/edit/{id}', 'RolesController@edit')->name('admin.roleEdit');
            // Route::post('roles/edit', 'RolesController@update')->name('admin.roleUpdate');
            // Route::get('roles/createe', 'RolesController@newRole')->name('admin.roleCreate');
            // Route::post('roles/createe', 'RolesController@create');
            // Route::post('roles/delete', 'RolesController@delete')->name('admin.deleteRole');


            Route::get('app/settings', 'AppSettings@showSettingsForm')->name('admin.appSettings');
            Route::post('app/settings/timezone', 'AppSettings@updateTimezone')->name('admin.settings.updateTimezone');
            Route::post('app/settings/basics', 'AppSettings@updateBasics')->name('admin.settings.updateBasics');
            Route::post('app/settings/maintenance', 'AppSettings@updateMaintenance')->name('admin.settings.updateMaintenanceMode');
            Route::post('app/settings/seo', 'AppSettings@updateSEO')->name('admin.settings.updateSEO');

            Route::get('announcements', 'AnnouncementController@announcements')->name('admin.announcement');
            Route::get('announcements/create', 'AnnouncementController@newAnnouncement')->name('admin.announcement.new');
            Route::post('announcements/create', 'AnnouncementController@create')->name('admin.announcement.create');
            Route::get('announcements/edit/{id}', 'AnnouncementController@edit')->name('admin.announcement.edit');
            Route::post('announcements/edit', 'AnnouncementController@editPost')->name('admin.announcement.edit.post');
            Route::post('announcements/delete', 'AnnouncementController@delete')->name('admin.announcement.delete');
            Route::get('announcements/details/{id}', 'AnnouncementController@details')->name('admin.announcement.view');


            Route::get('audiences', 'AudienceController@index')->name('admin.audiences');
            Route::get('audiences/create', 'AudienceController@createGet')->name('admin.audience.create');
            Route::post('audiences/create', 'AudienceController@create')->name('admin.audience.create');
            Route::get('audiences/view/{id}', 'AudienceController@details')->name('admin.audience.view');
            Route::get('audiences/update/{id}', 'AudienceController@updateGet')->name('admin.audience.edit');
            Route::post('audiences/update', 'AudienceController@update')->name('admin.audience.edit.post');
            Route::post('audiences/delete', 'AudienceController@delete')->name('admin.audience.delete');


            Route::get('reports', 'ReportsController@index')->name('admin.reports');
            Route::get('reports/create', 'ReportsController@createGet')->name('admin.report.create');
            Route::post('reports/create', 'ReportsController@create')->name('admin.report.create');
            Route::get('reports/view/{id}', 'ReportsController@details')->name('admin.report.view');
            Route::get('reports/update/{id}', 'ReportsController@updateGet')->name('admin.report.edit');
            Route::post('reports/update', 'ReportsController@update')->name('admin.report.edit.post');
            Route::post('reports/delete', 'ReportsController@delete')->name('admin.report.delete');


            Route::get('categories', 'CategoriesController@index')->name('admin.categories');
            Route::get('categories/create', 'CategoriesController@showCreatePage')->name('admin.category.create');
            Route::post('categories/create', 'CategoriesController@create');
            Route::get('categories/update/{id}', 'CategoriesController@showUpdatePage')->name('admin.category.edit');
            Route::post('categories/update', 'CategoriesController@update')->name('admin.category.update');
            Route::post('categories/delete', 'CategoriesController@delete')->name('admin.category.delete');


            Route::get('get-address-from-ip', [App\Http\Controllers\GeoLocationController::class, 'index']);
            Route::get('get-country-test', [App\Http\Controllers\CountresTestController::class, 'index']);

            Route::get('test', 'TestController@test')->name('admin.test');
            Route::get('/', function () {
                return view('admin.home');
            })->name('admin.home');
        });
    });
});
