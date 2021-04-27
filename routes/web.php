<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RedirectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\TopicController;

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
//Route::get('auth/login', [GoogleController::class, 'checkLogin']);

// redirect
Route::get('redirect', [RedirectController::class, 'checkLogin']);

// client
Route::get('/', [ClientController::class, 'getHome']);
Route::get('/home', [ClientController::class, 'getHome']);
Route::get('/post/{slug}', [ClientController::class, 'getPost']);
Route::get('/posts/new', [ClientController::class, 'getNewPosts']);
Route::get('/posts/popular', [ClientController::class, 'getPopularPosts']);
Route::get('/topic/{topic_slug}', [ClientController::class, 'getTopic']);
Route::get('/category/{category_slug}', [ClientController::class, 'getCategory']);
Route::get('/search', [ClientController::class, 'getSearch']);
Route::get('/posts/recommended', [ClientController::class, 'getRecommended'])->middleware('auth');
Route::get('/user/{id}', [ClientController::class, 'getUser']);

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
    Route::get('/recently', [\App\Http\Controllers\Member\PostController::class, 'getRecently']);
    Route::prefix('post')->group(function () {
        Route::get('/list', [\App\Http\Controllers\Member\PostController::class, 'getListPost']);
        Route::get('/view/{id}', [\App\Http\Controllers\Member\PostController::class, 'getViewPost']);
        Route::get('/add', [\App\Http\Controllers\Member\PostController::class, 'getAddPost']);
        Route::post('/add', [\App\Http\Controllers\Member\PostController::class, 'postAddPost']);
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
    Route::get('/recently', [\App\Http\Controllers\Member\PostController::class, 'getRecently']);
    Route::prefix('post')->group(function () {
        Route::get('/add', [\App\Http\Controllers\Member\PostController::class, 'getAddPost']);
        Route::get('list', [\App\Http\Controllers\Mod\PostController::class, 'getMyPost']);
        Route::get('list/my-post', [\App\Http\Controllers\Mod\PostController::class, 'getMyPost']);
        Route::get('list/post-i-manage', [\App\Http\Controllers\Mod\PostController::class, 'getPostIManage']);
        Route::get('/view/{id}', [\App\Http\Controllers\Member\PostController::class, 'getViewPost']);
        Route::get('/approval/{id}', [\App\Http\Controllers\Mod\PostController::class, 'getApprovalPost']);
        Route::post('/approval', [\App\Http\Controllers\Mod\PostController::class, 'postApprovalPost']);
        Route::get('/edit/{id}', [\App\Http\Controllers\Member\PostController::class, 'getEditPost']);
    });
    Route::prefix('/account')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Member\AccountController::class, 'getProfile']);
        Route::get('/security', [\App\Http\Controllers\Member\AccountController::class, 'getSecurity']);
    });
});

//Admin
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard/{id?}', [RedirectController::class, 'getAdminDashboard']);
    Route::prefix('manage-post')->group(function () {
        Route::get('get-category/{topic_id}', [\App\Http\Controllers\Admin\PostController::class, 'getCategory']);
        Route::get('list/my-post', [\App\Http\Controllers\Admin\PostController::class, 'getMyPost']);
        Route::get('list/post-i-manage/{id?}', [\App\Http\Controllers\Admin\PostController::class, 'showPost']);
        Route::post('fillter/{id?}', [\App\Http\Controllers\Admin\PostController::class, 'filter']);
        Route::get('/add', [\App\Http\Controllers\Admin\PostController::class, 'getAddPost']);
        Route::post('/add', [\App\Http\Controllers\Admin\PostController::class, 'postAddPost']);
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\PostController::class, 'getEditPost']);
        Route::post('/edit', [\App\Http\Controllers\Admin\PostController::class, 'postEditPost']);
        Route::get('/delete', [\App\Http\Controllers\Admin\PostController::class, 'postDeletePost']);
        Route::get('/view-post/{id}', [\App\Http\Controllers\Admin\PostController::class, 'viewDetail']);
        Route::get('delete_in_client', [\App\Http\Controllers\Admin\PostController::class, 'deleteInClient']);
        Route::get('view-post-r', [\App\Http\Controllers\Admin\PostController::class, 'deleteInAdmin']);
    });
    Route::prefix('manage-topic')->group(function () {
        Route::get('view', [TopicController::class, 'viewTopic']);
        Route::get('get-add', [TopicController::class, 'getAddTopic']);
        Route::post('post-add', [TopicController::class, 'postAddTopic']);
        Route::post('delete/{id}', [TopicController::class, 'delete']);
        Route::get('get-edit/{id}', [TopicController::class, 'getEdit']);
        Route::post('post-edit/{id}', [TopicController::class, 'postEdit']);
    });
    Route::prefix('manage-category')->group(function () {
        Route::get('view', [\App\Http\Controllers\Admin\CategoryController::class, 'viewCate']);
        Route::get('get-add', [\App\Http\Controllers\Admin\CategoryController::class, 'getAddCate']);
        Route::post('post-add', [\App\Http\Controllers\Admin\CategoryController::class, 'postAddCate']);
        Route::get('get-edit/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'getEdit']);
        Route::post('post-edit/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'postEdit']);
        Route::post('delete/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'delete']);
        Route::post('filter', [\App\Http\Controllers\Admin\CategoryController::class, 'filter']);
    });
    Route::prefix('manage-user')->group(function () {
        Route::get('view', [\App\Http\Controllers\Admin\UserController::class, 'viewUser']);
        Route::get('get-edit/{idU}', [\App\Http\Controllers\Admin\UserController::class, 'getEdit']);
        Route::post('post-edit/{idU}', [\App\Http\Controllers\Admin\UserController::class, 'postEdit']);
        Route::post('delete/{idU}', [\App\Http\Controllers\Admin\UserController::class, 'delete']);
        Route::get('view-post/{id}', [\App\Http\Controllers\Admin\UserController::class, 'viewPost']);
        Route::post('ban/{idUser?}', [\App\Http\Controllers\Admin\UserController::class, 'banUser']);
        Route::get('ban_in_client', [\App\Http\Controllers\Admin\UserController::class, 'banUser']);
    });
    Route::prefix('manage-report')->group(function () {
        Route::get('view', [\App\Http\Controllers\Admin\ReportController::class, 'viewReport']);
        Route::get('view-post/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'viewPost']);
        Route::post('filter',[\App\Http\Controllers\Admin\ReportController::class,'getFilter']);
        Route::post('delete/{id}',[\App\Http\Controllers\Admin\ReportController::class,'delete']);
        Route::post('view-story-user/{id}',[\App\Http\Controllers\Admin\ReportController::class,'viewStoryUser']);
        Route::post('delete-all-report/{id}',[\App\Http\Controllers\Admin\ReportController::class,'deleteAllReport']);

    });
    Route::prefix('/account')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Admin\AccountControllers::class, 'getProfile']);
        Route::post('/profile', [\App\Http\Controllers\Admin\AccountControllers::class, 'postProfile']);
        Route::get('/security', [\App\Http\Controllers\Admin\AccountControllers::class, 'getSecurity']);
        Route::get('/forgot-password', [\App\Http\Controllers\Admin\AccountControllers::class, 'getForgotPassword']);
        Route::post('/change-password', [\App\Http\Controllers\Admin\AccountControllers::class, 'postChangePassword']);
    });


});


