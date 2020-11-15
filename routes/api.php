<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/email-verification/{token}', 'UserManagementController@validateEmail');
Route::post('/password-reset/{token}', 'UserManagementController@doPasswordReset');
Route::post('/login', 'AuthenticationController@login');
Route::post('/signup', 'UserManagementController@createUser');
Route::post('/forgot-password', 'UserManagementController@onForgotPassword');


Route::middleware([
    'isLoggedIn'
])->group(function () {


    /*
          ****************  Miscellaneous Routes Starts Here ***************************
    */
    Route::get('/auth/me', 'AuthenticationController@me');
    /*
            ************  Miscellaneous Routes Ends Here *********************************
    */

    /*
         **************** UserManagement Starts Here   ************************
    */
    Route::get('/user-management/users', 'UserManagementController@getUsers');
    Route::get('/user-management/users/{identifier}', 'UserManagementController@getUserByIdentifier');
    Route::patch("/user-management/users/{identifier}", 'UserManagementController@deActivateAUserAccount');
    /*
       ******************   UserManagement Ends Here *************************
    */

    /*
        ************ RoleManagement starts here ******************
    */
    Route::post('/role-management/roles/{roleCode}/assign', 'RoleManagementController@assignRoleToUser');
    Route::get('/role-management/roles/{code}', 'RoleManagementController@get');
    Route::get('/role-management/roles', 'RoleManagementController@getAll');
    Route::post('/role-management/roles', 'RoleManagementController@createRole');
    /*
          ************ RoleManagement Ends Here *******************
    */


    /*
      ************ PermissionManagement starts here ******************
     */
    Route::post('/permission-management/permissions/{permissionCode}/assign', 'PermissionController@assignPermissionToRole');
    Route::get('/permission-management/permissions/{permissionCode}', 'PermissionController@get');
    Route::get('/permission-management/permissions', 'PermissionController@getAll');
    Route::post('/permission-management/permissions', 'PermissionController@createPermission');
    /*
          ************ RoleManagement Ends Here *******************
    */


});

