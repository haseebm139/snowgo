<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\ServiceProviderController;


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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forget-password', [AuthController::class, 'forgetPassword']);
Route::post('update-forget-password', [AuthController::class, 'updateForgetPassword']);


// Authorized API's

Route::middleware(['auth:api'])->group(function () {
    Route::post('edit-profile',[AuthController::class,'editProfile'])->name('edit.profile');
    Route::post('change-password',[AuthController::class,'changePassword'])->name('change.password');
    Route::get('clear',[AuthController::class,'clearCache'])->name('clear');
    Route::post('update-user-location',[AuthController::class,'updateUserLocation'])->name('update-user-location');


    Route::controller(TaskController::class)->group(function ()
    {
        Route::post('create-task','createTask')->name('create.task');
    });


    /* Service Provider Controller Routes */
    Route::controller(ServiceProviderController::class)->group(function ()
    {
        Route::get('service-provider/reviews','reviews')->name('reviews');
    });

});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
