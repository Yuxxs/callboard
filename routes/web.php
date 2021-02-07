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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    if ($request->authorize()) {
        $request->fulfill();
        if ($request->user()->role->slug == 'user')
            return redirect(route('user.home'));
        elseif ($request->user()->role->slug == 'moderator')
            return redirect(route('moderator.home'));
        elseif ($request->user()->role->slug == 'admin')
            return redirect(route('admin.home'));
    } else redirect(route('login'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('verified')->group(function () {
    Route::middleware(['access.route:admin'])->group(function () {
        Route::get('/home/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
        Route::get('/home/admin/register_page', [App\Http\Controllers\AdminController::class, 'showRegistrationForm'])->name('admin.register_page');
        Route::post('/home/admin/register_user', [App\Http\Controllers\AdminController::class, 'registerUser'])->name('admin.register_user');
    });
    Route::middleware(['access.route:moderator'])->group(function () {
        Route::get('/home/moderator', [App\Http\Controllers\ModeratorController::class, 'index'])->name('moderator.home');
        Route::post('ad/moderation/create', [App\Http\Controllers\ModeratorController::class, 'createModeration'])->name('moderator.create_moderation');
        Route::post('ad/moderation/publish', [App\Http\Controllers\ModeratorController::class, 'publishAd'])->name('moderator.publish_ad');
    });
    Route::middleware(['access.route:user'])->group(function () {

        Route::get('/home', [App\Http\Controllers\UserController::class, 'index'])->name('user.home');

        Route::middleware(['access.ad'])->group(function () {
            Route::post('/ad/save', [App\Http\Controllers\AdController::class, 'saveAd'])->name('user.save_ad');
            Route::get('/ad/edit', [App\Http\Controllers\AdController::class, 'editAd'])->name('user.edit_ad');
            Route::delete('/ad/delete', [App\Http\Controllers\AdController::class, 'deleteAd'])->name('user.delete_ad');
            Route::get('/ad/choose_category', [App\Http\Controllers\AdController::class, 'adChooseCategory'])->name('user.choose_category');
            Route::post('/ad/send_to_moderation', [App\Http\Controllers\AdController::class, 'sendToModeration'])->name('user.send_ad');
        });

    });
    Route::get('/ad/moderation', [App\Http\Controllers\ModeratorController::class, 'moderation'])->name('ad.moderation')->middleware('show.ad');
    Route::get('/ad', [App\Http\Controllers\AdController::class, 'index'])->name('ad')->middleware('show.ad');
});
