<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\UsersController;

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

# API Routes
Route::group(['prefix' => 'v1', 'namespace' => 'api\v1'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);

    Route::middleware(['auth:api'])->group(function (){
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('get-user-details', [UsersController::class, 'getUserDetails']);
        Route::get('get-all-users', [UsersController::class, 'getAllUsers']);        
    });
});
