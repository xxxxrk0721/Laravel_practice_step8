<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/user/dashboard', function(){
//    return view('admin.top');
//});

//Route::get('/user/dashboard', function() {
//    return app(AuthenticatedSessionController::class)->index();
//})->name('user.dashboard');

//Route::get('/user/dashboard', [AuthenticatedSessionController::class, 'index'])->name('user.dashboard');
//ユーザーログイン語
//Route::post('/login', [AdminLoginController::class, 'store'])->name('login.store');

// ユーザーログアウト
Route::delete('/login', [AuthenticatedSessionController::class, 'destroy'])->name('login.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/admin/register', [AdminRegisterController::class, 'create'])
    ->name('admin.register');

Route::post('/admin/register', [AdminRegisterController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);


// 管理ログイン画面
Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
// 管理ログイン
Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store');
// 管理ログアウト
Route::delete('/admin/login', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy');

// 管理ログイン後のみアクセス可
Route::middleware('auth:admin')->group(function () {
//    Route::get('/admin', function () {
//        return view('admin.top');
//    })->name('admin.top');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');//一覧表示
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit'); //編集画面の表示
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update'); //登録内容の編集
    Route::match(['get', 'post'],'/tasks/store', [TaskController::class, 'store'])->name('tasks.store'); //新規登録
    Route::delete('/tasks/{id}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy'); // ソフトデリート

});

// ユーザーログイン後のみアクセス可
Route::middleware('auth:users')->group(function () {
    Route::get('/user/dashboard', [TaskController::class, 'userIndex'])->name('user.dashboard');
    Route::get('/user/dashboard/{id}/edit', [TaskController::class, 'userEdit'])->name('user.dashboard.edit'); //編集画面の表示
    Route::put('/user/dashboard/{id}', [TaskController::class, 'userUpdate'])->name('user.dashboard.update'); //登録内容の編集
    Route::match(['get', 'post'],'/user/dashboard/store', [TaskController::class, 'userStore'])->name('user.dashboard.store'); //新規登録
    Route::delete('/user/dashboard/{id}/delete', [TaskController::class, 'userDestroy'])->name('user.dashboard.destroy'); // ソフトデリート
//    Route::get('/admin', function () {
//        return view('admin.top');
//    })->name('admin.top');
});

require __DIR__.'/auth.php';
