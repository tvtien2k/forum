<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RedirectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NoticeController;

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

// auth and verified
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// google auth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// redirect
Route::get('redirect', [RedirectController::class, 'redirectLogin']);

// client
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [ClientController::class, 'getHome']);
Route::get('/post/{slug}', [ClientController::class, 'getPost']);

/*
// insert data
Route::prefix('insert')->group(function () {
    Route::get('topic', [\App\Http\Controllers\InsertDataController::class, 'insertTopic']);
    Route::get('category', [\App\Http\Controllers\InsertDataController::class, 'insertCategory']);
    Route::get('post', [\App\Http\Controllers\InsertDataController::class, 'insertPost']);
});
*/

// ajax
Route::prefix('ajax')->group(function () {
    Route::get('/getCategory/{topic_id}', [AjaxController::class, 'getCategory']);
});

// notice
Route::prefix('notice')->middleware('auth')->group(function () {
    Route::get('/add-post', [NoticeController::class, 'getAddPost']);
    Route::get('/update-post', [NoticeController::class, 'getUpdatePost']);
    Route::get('/add-comment', [NoticeController::class, 'getAddComment']);
});

// member
Route::prefix('member')->middleware('member')->group(function () {
    Route::get('/dashboard', [RedirectController::class, 'getMemberDashboard']);
    Route::prefix('post')->group(function () {
        Route::get('/add', [\App\Http\Controllers\Member\PostController::class, 'getAddPost']);
        Route::post('/add', [\App\Http\Controllers\Member\PostController::class, 'postAddPost']);
        Route::get('/list', [\App\Http\Controllers\Member\PostController::class, 'getListPost']);
        Route::post('/delete', [\App\Http\Controllers\Member\PostController::class, 'postDeletePost']);
        Route::get('/edit/{id}', [\App\Http\Controllers\Member\PostController::class, 'getEditPost']);
        Route::post('/edit', [\App\Http\Controllers\Member\PostController::class, 'postEditPost']);
        Route::get('/view/{id}', [\App\Http\Controllers\Member\PostController::class, 'getViewPost']);
        Route::post('/comment', [\App\Http\Controllers\Member\PostController::class, 'postComment']);
    });
    Route::get('/notice', [\App\Http\Controllers\Member\NoticeController::class, 'getNotice']);
});

// mod
Route::prefix('mod')->middleware('mod')->group(function () {
    Route::get('/', function () {
        return "mod";
    });
});

//admin
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', function () {
        return "admin";
    });
});
