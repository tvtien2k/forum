<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RedirectController;
use App\Http\Controllers\ClientController;

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
Route::get('/', [ClientController::class, 'getHome']);
Route::get('/home', [ClientController::class, 'getHome']);
Route::get('/post/{slug}', [ClientController::class, 'getPost']);
Route::get('/posts/new', [ClientController::class, 'getNewPosts']);
Route::get('/topic/{topic_slug}', [ClientController::class, 'getTopic']);
Route::get('/category/{category_slug}', [ClientController::class, 'getCategory']);
Route::get('/user/{id}', [ClientController::class, 'getUser']);
Route::get('/search', [ClientController::class, 'getSearch']);

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
    Route::get('/getPost/{key}', [AjaxController::class, 'getPost']);
});

// member
Route::prefix('member')->middleware('member')->group(function () {
    Route::get('/dashboard', [RedirectController::class, 'getMemberDashboard']);
    Route::prefix('post')->group(function () {
        Route::get('/add', [\App\Http\Controllers\Member\PostController::class, 'getAddPost']);
        Route::post('/add', [\App\Http\Controllers\Member\PostController::class, 'postAddPost']);
        Route::get('/list', [\App\Http\Controllers\Member\PostController::class, 'getListPost']);
        Route::get('/view/{id}', [\App\Http\Controllers\Member\PostController::class, 'getViewPost']);
        Route::get('/edit/{id}', [\App\Http\Controllers\Member\PostController::class, 'getEditPost']);
        Route::post('/edit', [\App\Http\Controllers\Member\PostController::class, 'postEditPost']);
        Route::post('/comment', [\App\Http\Controllers\Member\PostController::class, 'postComment']);
        Route::post('/delete', [\App\Http\Controllers\Member\PostController::class, 'postDeletePost']);
    });
    Route::prefix('/report')->group(function () {
        Route::post('/add', [\App\Http\Controllers\Member\ReportController::class, 'postAddReport']);
    });
    Route::prefix('/account')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Member\AccountController::class, 'getProfile']);
        Route::post('/profile', [\App\Http\Controllers\Member\AccountController::class, 'postProfile']);
        Route::get('/security', [\App\Http\Controllers\Member\AccountController::class, 'getSecurity']);
        Route::get('/forgot-password', [\App\Http\Controllers\Member\AccountController::class, 'getForgotPassword']);
        Route::post('/change-password', [\App\Http\Controllers\Member\AccountController::class, 'postChangePassword']);
    });
});

// mod
Route::prefix('mod')->middleware('mod')->group(function () {
    Route::get('/dashboard', [RedirectController::class, 'getModDashboard']);
    Route::prefix('post')->group(function () {
        Route::get('/add', [\App\Http\Controllers\Member\PostController::class, 'getAddPost']);
        Route::get('list', [\App\Http\Controllers\Mod\PostController::class, 'getMyPost']);
        Route::get('list/my-post', [\App\Http\Controllers\Mod\PostController::class, 'getMyPost']);
        Route::get('list/post-i-manage', [\App\Http\Controllers\Mod\PostController::class, 'getPostIManage']);
        Route::post('list/post-i-manage', [\App\Http\Controllers\Mod\PostController::class, 'postPostIManage']);
        Route::get('/view/{id}', [\App\Http\Controllers\Member\PostController::class, 'getViewPost']);
        Route::get('/approval/{id}', [\App\Http\Controllers\Mod\PostController::class, 'getApprovalPost']);
        Route::post('/approval', [\App\Http\Controllers\Mod\PostController::class, 'postApprovalPost']);
        Route::get('/edit/{id}', [\App\Http\Controllers\Member\PostController::class, 'getEditPost']);
    });
});

//admin
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', function () {
        return "admin";
    });
});
