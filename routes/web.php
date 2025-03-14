<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRegisterController;

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
    return view('login');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/admin/register', [AdminRegisterController::class, 'create'])
    ->name('admin.register');

Route::post('/admin/register', [AdminRegisterController::class, 'store']);


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

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
});

require __DIR__.'/auth.php';
