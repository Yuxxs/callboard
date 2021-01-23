<?php

use Illuminate\Support\Facades\Auth;
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

Route::middleware(['access:admin'])->group(function () {
    Route::get('/Home/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_home');
});
Route::middleware(['access:moderator'])->group(function () {
    Route::get('/Home/moderator', [App\Http\Controllers\ModeratorController::class, 'index'])->name('moderator_home');
});
Route::middleware(['access:user'])->group(function () {
    Route::get('/Home', [App\Http\Controllers\UserController::class, 'index'])->name('user_home');
});
