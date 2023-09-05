<?php

use Illuminate\Support\Facades\Route;
// For Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserPatternController;


// For User
use App\Http\Controllers\User\UserController as UController;
use App\Http\Controllers\Admin\RoleController;

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
    return redirect()->route('login');
});

Auth::routes();






Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {

   route::get('login','user_login')->name('login')->middleware('guest');
   route::post('loginAdminProcess','loginAdminProcess')->name('loginAdminProcess') ;

   route::get('user-register','userRegister')->name('user-register')->middleware('guest');
   route::post('user-register-process','RegisterProcess')->name('user-register-process');

   Route::get('forgot-password', 'forgotPasswords')->name('forgot-password');
   Route::post('forgotPassword', 'forgotPassword')->name('forgotPassword');
   Route::post('updatePassword', 'updatePassword')->name('updatePassword');
   route::get('resetpassword/{id}','resetpassword')->name('resetpassword');

});



Route::middleware(['auth','can:isAdmin'])->prefix('admin')->group(function()
{
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('userspattern', UserPatternController::class);
    Route::get('user-change-status', [UserController::class,'change_status'])->name('admin-user-change-status');
    Route::controller(AdminController::class)->group(function ()
    {
        Route::get('dashboard', 'dashboard')->name('admin.dashboard');
        Route::get('profile', 'profile')->name('admin.profile');
        route::post('profile-update','profileUpdate')->name('profile-update');
    });
});

Route::middleware(['auth','can:isUser'])->prefix('user')->group(function(){});

Route::middleware(['auth','can:isService'])->prefix('service-provider')->group(function(){});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
