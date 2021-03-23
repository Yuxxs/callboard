<?php


use App\Http\Requests\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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



Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    if ($request->authorize()) {
        $request->fulfill();
        return redirect(route($request->user()->role->slug.'.home'));
    } else redirect(route('login'));
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('verified')->group(function () {
    Route::middleware(['access.route:admin'])->group(function () {
        Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
        Route::get('/admin/home/edit_user/{id?}', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.edit_user');
        Route::post('/admin/home/save_user', [App\Http\Controllers\AdminController::class, 'saveUser'])->name('admin.save_user');
        Route::delete('/admin/home/delete_user/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.delete_user');
           Route::post('/admin/home/save_category/{id?}', [App\Http\Controllers\AdminController::class, 'saveCategory'])->name('admin.save_category');
        Route::delete('/admin/home/delete_category/{id}', [App\Http\Controllers\AdminController::class, 'deleteCategory'])->name('admin.delete_category');

    });
    Route::middleware(['access.route:moderator'])->group(function () {
        Route::get('/moderator/home/', [App\Http\Controllers\ModeratorController::class, 'index'])->name('moderator.home');
        Route::post('ad/moderation/create', [App\Http\Controllers\ModeratorController::class, 'createModeration'])->name('moderator.create_moderation');
        Route::post('ad/moderation/publish', [App\Http\Controllers\ModeratorController::class, 'publishAd'])->name('moderator.publish_ad');
    });
    Route::middleware(['access.route:user'])->group(function () {

        Route::get('/user/home', [App\Http\Controllers\UserController::class, 'index'])->name('user.home');

        Route::middleware(['access.ad'])->group(function () {
            Route::post('/ad/save', [App\Http\Controllers\AdController::class, 'saveAd'])->name('user.save_ad');
            Route::get('/ad/edit', [App\Http\Controllers\AdController::class, 'editAd'])->name('user.edit_ad');
            Route::delete('/ad/{id}/delete', [App\Http\Controllers\AdController::class, 'deleteAd'])->name('user.delete_ad');
            Route::get('/ad/choose_category', [App\Http\Controllers\AdController::class, 'adChooseCategory'])->name('user.choose_category');
            Route::post('/ad/send_to_moderation', [App\Http\Controllers\AdController::class, 'sendToModeration'])->name('user.send_ad');
        });

    });
    Route::get('/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');

    Route::get('/ad/moderation', [App\Http\Controllers\ModeratorController::class, 'moderation'])->name('ad.moderation')->middleware('show.ad');
});

Route::get('/ad', [App\Http\Controllers\AdController::class, 'index'])->name('ad')->middleware('show.ad');
Route::get('/', [App\Http\Controllers\AdController::class, 'searchAds'])->name('ad.search');
