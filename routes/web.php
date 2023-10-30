<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;

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

Route::get('forgot-password/{token}/{ismobile?}', [ResetPasswordController::class, 'viewResetPassword'])->name('view-reset-password');
Route::post('reset-password/{token}/{ismobile?}', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');
Route::any('activation/{token}', [HomeController::class, 'activation'])->name('activation');
Route::get('success', [HomeController::class, 'success'])->name('success');

