<?php


use App\Http\Requests\EmailVerificationRequest;
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

Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
if($request->authorize()){
    $request->fulfill();
    if($request->user()->role->slug=='user')
        return redirect(route('user_home'));
    elseif($request->user()->role->slug=='moderator')
        return redirect(route('moderator_home'));
    elseif($request->user()->role->slug=='admin')
        return redirect(route('admin_home'));
    else redirect(route('login'));
}
else redirect(route('login'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('verified')->group(function () {
    Route::middleware(['access:admin'])->group(function () {
        Route::get('/Home/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_home');
    });
    Route::middleware(['access:moderator'])->group(function () {
        Route::get('/Home/moderator', [App\Http\Controllers\ModeratorController::class, 'index'])->name('moderator_home');
    });
    Route::middleware(['access:user'])->group(function () {
        Route::get('/Home', [App\Http\Controllers\UserController::class, 'index'])->name('user_home');
    });
});
