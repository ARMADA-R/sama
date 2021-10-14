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
    'middleware' => ['defineAdmin'], //, 'AuthenticateAdminsSession'
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



            Route::get('roles', [App\Http\Controllers\Admin\RolesController::class, "roles"])->name('admin.roles');
            Route::get('roles/create', [App\Http\Controllers\Admin\RolesController::class, "showCreateRoleView"])->name('admin.roles.create');
            Route::post('roles/create', [App\Http\Controllers\Admin\RolesController::class, "create"]);
            Route::post('roles/delete', [App\Http\Controllers\Admin\RolesController::class, "delete"])->name('admin.roles.delete');
            Route::get('roles/update/{id}', [App\Http\Controllers\Admin\RolesController::class, "showUpdateForm"])->name('admin.roles.update');
            Route::post('roles/update/{id}', [App\Http\Controllers\Admin\RolesController::class, "update"]);



            Route::get('parent/mother/search', [App\Http\Controllers\Admin\ParentsController::class, "mothersSearch"])->name('admin.parents.mother.search');
            Route::get('parent/father/search', [App\Http\Controllers\Admin\ParentsController::class, "fathersSearch"])->name('admin.parents.father.search');

            Route::get('students', [App\Http\Controllers\Admin\StudentsController::class, "students"])->name('admin.students');;
            Route::get('students/create', [App\Http\Controllers\Admin\StudentsController::class, "showCreateStudentView"])->name('admin.students.create');
            Route::post('students/create', [App\Http\Controllers\Admin\StudentsController::class, "create"]);
            Route::get('students/edit/{id}', [App\Http\Controllers\Admin\StudentsController::class, "showUpdateStudentView"])->name('admin.students.update');
            Route::post('students/edit/{id}', [App\Http\Controllers\Admin\StudentsController::class, "update"]);
            Route::post('students/edit/{id}/student', [App\Http\Controllers\Admin\StudentsController::class, "updateStudent"])->name('admin.students.update.student');
            Route::post('students/edit/{id}/mother', [App\Http\Controllers\Admin\StudentsController::class, "updateMother"])->name('admin.students.update.mother');
            Route::post('students/edit/{id}/father', [App\Http\Controllers\Admin\StudentsController::class, "updateFather"])->name('admin.students.update.father');
            Route::post('students/edit/{id}/addressTransEmergency', [App\Http\Controllers\Admin\StudentsController::class, "updateAddress_Transportation_Emergency"])->name('admin.students.update.addressTransEmergency');
            Route::post('students/edit/{id}/sequence', [App\Http\Controllers\Admin\StudentsController::class, "updateSequence"])->name('admin.students.update.sequence');
            Route::post('students/edit/{id}/languages', [App\Http\Controllers\Admin\StudentsController::class, "updateLanguages"])->name('admin.students.update.languages');
            Route::post('students/edit/{id}/health', [App\Http\Controllers\Admin\StudentsController::class, "updateHealth"])->name('admin.students.update.health');
            Route::post('students/delete', [App\Http\Controllers\Admin\StudentsController::class, "delete"])->name('admin.students.delete');




            Route::get('parents', [App\Http\Controllers\Admin\ParentsController::class, "parents"])->name('admin.parents');;
            Route::get('parents/deactivated', [App\Http\Controllers\Admin\ParentsController::class, "deactivatedParents"])->name('admin.parents.deactivated');;
            Route::get('parents/deactivated/excel', [App\Http\Controllers\Admin\ParentsController::class, "deactivatedParentsExcel"])->name('admin.parents.deactivated.excel');
            Route::get('parents/create', [App\Http\Controllers\Admin\ParentsController::class, "showCreateParentView"])->name('admin.parents.create');
            Route::post('parents/create', [App\Http\Controllers\Admin\ParentsController::class, "create"]);
            Route::get('parents/edit/{id}', [App\Http\Controllers\Admin\ParentsController::class, "showUpdateParentView"])->name('admin.parents.update');
            Route::post('parents/edit/{id}', [App\Http\Controllers\Admin\ParentsController::class, "update"]);
            Route::post('parents/account/edit/{id}', [App\Http\Controllers\Admin\ParentsController::class, "updateAccount"])->name('admin.parents.acc.update');
            Route::post('parents/delete', [App\Http\Controllers\Admin\ParentsController::class, "delete"])->name('admin.parents.delete');





            Route::get('stages', [App\Http\Controllers\Admin\StagesController::class, "stages"])->name('admin.stages');;
            Route::get('stages/create', [App\Http\Controllers\Admin\StagesController::class, "showCreateView"])->name('admin.stages.create');
            Route::post('stages/create', [App\Http\Controllers\Admin\StagesController::class, "create"]);
            Route::get('stages/edit/{id}', [App\Http\Controllers\Admin\StagesController::class, "showUpdateView"])->name('admin.stages.update');
            Route::post('stages/edit/{id}', [App\Http\Controllers\Admin\StagesController::class, "update"]);
            Route::post('stages/delete', [App\Http\Controllers\Admin\StagesController::class, "delete"])->name('admin.stages.delete');
            Route::get('stage/levels', [App\Http\Controllers\Admin\StagesController::class, "getStageLevelsHaveDivisions"])->name('admin.stage.levels');
            Route::get('stage/levels/all', [App\Http\Controllers\Admin\StagesController::class, "getStageLevels"])->name('admin.stage.levels.all');




            Route::get('levels', [App\Http\Controllers\Admin\LevelsController::class, "levels"])->name('admin.levels');;
            Route::get('levels/create', [App\Http\Controllers\Admin\LevelsController::class, "showCreateView"])->name('admin.levels.create');
            Route::post('levels/create', [App\Http\Controllers\Admin\LevelsController::class, "create"]);
            Route::get('levels/edit/{id}', [App\Http\Controllers\Admin\LevelsController::class, "showUpdateView"])->name('admin.levels.update');
            Route::post('levels/edit/{id}', [App\Http\Controllers\Admin\LevelsController::class, "update"]);
            Route::post('levels/delete', [App\Http\Controllers\Admin\LevelsController::class, "delete"])->name('admin.levels.delete');





            Route::get('semesters', [App\Http\Controllers\Admin\SemestersController::class, "semesters"])->name('admin.semesters');;
            Route::get('semesters/create', [App\Http\Controllers\Admin\SemestersController::class, "showCreateView"])->name('admin.semesters.create');
            Route::post('semesters/create', [App\Http\Controllers\Admin\SemestersController::class, "create"]);
            Route::get('semesters/edit/{id}', [App\Http\Controllers\Admin\SemestersController::class, "showUpdateView"])->name('admin.semesters.update');
            Route::post('semesters/edit/{id}', [App\Http\Controllers\Admin\SemestersController::class, "update"]);
            Route::post('semesters/delete', [App\Http\Controllers\Admin\SemestersController::class, "delete"])->name('admin.semesters.delete');






            Route::get('years/academic', [App\Http\Controllers\Admin\AcademicYearsController::class, "academicYears"])->name('admin.academicYears');;
            Route::get('years/academic/create', [App\Http\Controllers\Admin\AcademicYearsController::class, "showCreateView"])->name('admin.academicYears.create');
            Route::post('years/academic/create', [App\Http\Controllers\Admin\AcademicYearsController::class, "create"]);
            Route::get('years/academic/edit/{id}', [App\Http\Controllers\Admin\AcademicYearsController::class, "showUpdateView"])->name('admin.academicYears.update');
            Route::post('years/academic/edit/{id}', [App\Http\Controllers\Admin\AcademicYearsController::class, "update"]);
            Route::post('years/academic/delete', [App\Http\Controllers\Admin\AcademicYearsController::class, "delete"])->name('admin.academicYears.delete');





            Route::get('divisions', [App\Http\Controllers\Admin\DivisionsController::class, "divisions"])->name('admin.divisions');;
            Route::get('divisions/create', [App\Http\Controllers\Admin\DivisionsController::class, "showCreateView"])->name('admin.divisions.create');
            Route::post('divisions/create', [App\Http\Controllers\Admin\DivisionsController::class, "create"]);
            Route::get('divisions/edit/{id}', [App\Http\Controllers\Admin\DivisionsController::class, "showUpdateView"])->name('admin.divisions.update');
            Route::post('divisions/edit/{id}', [App\Http\Controllers\Admin\DivisionsController::class, "update"]);
            Route::post('divisions/delete', [App\Http\Controllers\Admin\DivisionsController::class, "delete"])->name('admin.divisions.delete');





            Route::get('headmasters', [App\Http\Controllers\Admin\HeadmastersController::class, "headmasters"])->name('admin.headmasters');;
            Route::get('headmasters/create', [App\Http\Controllers\Admin\HeadmastersController::class, "showCreateView"])->name('admin.headmasters.create');
            Route::post('headmasters/create', [App\Http\Controllers\Admin\HeadmastersController::class, "create"]);
            Route::get('headmasters/edit/{id}', [App\Http\Controllers\Admin\HeadmastersController::class, "showUpdateView"])->name('admin.headmasters.update');
            Route::post('headmasters/edit/{id}', [App\Http\Controllers\Admin\HeadmastersController::class, "update"]);
            Route::post('headmasters/delete', [App\Http\Controllers\Admin\HeadmastersController::class, "delete"])->name('admin.headmasters.delete');
            Route::post('headmasters/edit/{id}/password', [App\Http\Controllers\Admin\HeadmastersController::class, "updatePassword"])->name('admin.headmasters.update.password');
            Route::post('headmasters/edit/{id}/status', [App\Http\Controllers\Admin\HeadmastersController::class, "updateAccountStatus"])->name('admin.headmasters.update.status');






            Route::get('guidanceCounselors', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "guidanceCounselors"])->name('admin.guidanceCounselors');;
            Route::get('guidanceCounselors/create', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "showCreateView"])->name('admin.guidanceCounselors.create');
            Route::post('guidanceCounselors/create', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "create"]);
            Route::get('guidanceCounselors/edit/{id}', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "showUpdateView"])->name('admin.guidanceCounselors.update');
            Route::post('guidanceCounselors/edit/{id}', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "update"]);
            Route::post('guidanceCounselors/delete', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "delete"])->name('admin.guidanceCounselors.delete');
            Route::post('guidanceCounselors/edit/{id}/password', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "updatePassword"])->name('admin.guidanceCounselors.update.password');
            Route::post('guidanceCounselors/edit/{id}/status', [App\Http\Controllers\Admin\GuidanceCounselorsController::class, "updateAccountStatus"])->name('admin.guidanceCounselors.update.status');




            Route::get('studyMaterials', [App\Http\Controllers\Admin\StudyMaterialsController::class, "studyMaterials"])->name('admin.studyMaterials');;
            Route::get('studyMaterials/create', [App\Http\Controllers\Admin\StudyMaterialsController::class, "showCreateView"])->name('admin.studyMaterials.create');
            Route::post('studyMaterials/create', [App\Http\Controllers\Admin\StudyMaterialsController::class, "create"]);
            Route::get('studyMaterials/edit/{id}', [App\Http\Controllers\Admin\StudyMaterialsController::class, "showUpdateView"])->name('admin.studyMaterials.update');
            Route::post('studyMaterials/edit/{id}', [App\Http\Controllers\Admin\StudyMaterialsController::class, "update"]);
            Route::post('studyMaterials/delete', [App\Http\Controllers\Admin\StudyMaterialsController::class, "delete"])->name('admin.studyMaterials.delete');





            
            Route::get('test', 'TestController@test')->name('admin.test');
            Route::get('/', function () {
                return view('admin.home');
            })->name('admin.home');
        });
    });
});
