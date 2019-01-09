<?php

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

Route::get('/',function(){
    return redirect('/login');
});

Route::get('/home', 'Controller@afterLogin');
Auth::routes();

Route::get('/logout',"Auth\LoginController@logout");
Route::get('/dashboard','HomeController@index');
Route::get('/board','CodeController@index');
Route::get('/changeLanguage','Controller@changeLanguage');
Route::get('/user_deactivate_error','ErrorController@user_deactivate_error');
Route::get('/license_not_support_error','ErrorController@license_not_support_error');

Route::post('/user/add/action','UserController@addUserAction');

Route::group(
    ['prefix'=>'user'],function(){
        Route::get('/showAddUser','UserController@showAddUser')->name('show_add_user');
        Route::get('/showAllUser',"UserController@showAllUser")->name('show_all_user');
        Route::get('/activateUser',"UserController@activateUser");
        Route::post('/registerUser','UserController@registerUser');
        Route::get('/deleteUser/{id}','UserController@deleteUser');    
        
        Route::get('/editUser/{id}','UserController@showEditUserForm');
        Route::get('/showSonList','UserController@showSonList')->name('show_son_list');

        Route::get('/changePassword/{id}','UserController@showPasswordForm')->name('show_password_form');
        Route::post('/changePassword/{id}','UserController@changePassword');
        Route::get('/showProfile','UserController@showProfile')->name('update_profile');
        Route::post('/updateProfile','UserController@updateProfile');
    }    
);

Route::group(
    ['prefix'=>'board'],function(){
        Route::get('/showRegisterBoard',"BoardController@showRegisterBoard")->name('show_register_board');
        Route::get('/showAllBoards',"BoardController@showAllBoards")->name('show_all_boards');
        Route::post('/registerBoard','BoardController@registerBoard');
        Route::get('/showAssignBoard','BoardController@showAssignBoard')->name('show_assign_board');
        Route::get('/activateBoard','BoardController@activateBoard');
        Route::post('/assignBoard','BoardController@assignBoard');
        Route::get('/assignStartupPeriod','BoardController@assignStartupPeriod');
        Route::get('/showReturnBoard','BoardController@showReturnBoard')->name('show_return_board');
        Route::post('/returnBoard','BoardController@returnBoard');
        Route::get('/exportBoardData','BoardController@exportBoardData');
        Route::get('/deleteBoard/{id}','BoardController@deleteBoard');
    }
);

Route::group(
    ['prefix'=>'code'],function(){
        Route::get('/showGenerateLicenseForm','CodeController@showGenerateLicenseForm')->name('show_generate_license_form');
        Route::get('/showGenerateLicenseForm/{default_version_id}/{default_mac}/{default_request_key}','CodeController@showGenerateLicenseForm')->name('show_generate_license_form');
        Route::get('/showGenerateStartupForm/{default_startup}','CodeController@showGenerateStartupForm')->name('show_generate_startup_form');
        Route::get('/showGenerateStartupForm','CodeController@showGenerateStartupForm')->name('show_generate_startup_form');
        Route::get('/showAssignCodeForm','CodeController@showAssignCodeForm')->name('show_assign_code_form');
        Route::get('/showAllCodes','CodeController@showAllCodes')->name('show_all_codes');
        Route::post('/registerLicenseCode','CodeController@registerLicenseCode');
        Route::post('/registerStartupCode','CodeController@registerStartupCode');
        Route::post('/assignLicenseCode','CodeController@assignLicenseCode');
        Route::post('/assignStartupCode','CodeController@assignStartupCode');
        Route::get('/exportCodeData','CodeController@exportCodeData');
    }
);

// Route::get('/admin_user','UserController@index')->name('admin_user');
