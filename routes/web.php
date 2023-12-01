<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;

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

Route::middleware(['auth.user'])->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks');

    Route::post('/create_task', [TaskController::class, 'createTask'])->name('create.task');
    Route::post('/delete_task', [TaskController::class, 'deleteTask'])->name('delete.task');
    Route::post('/complete_task', [TaskController::class, 'completeTask'])->name('complete.task');

    Route::get('/showTask/{id}', [TaskController::class, 'showTask'])->name('show.task');
    Route::put('showTask/{id}', [TaskController::class, 'updateTask'])->name('update.task');

    Route::get('/create_task', [TaskController::class, 'createTaskIndex'])->name('create.task');

    Route::post('/to_filter', [TaskController::class, 'index'])->name('filter');

    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::get('/register', [RegistrationController::class, 'index'])->name('register');
Route::post('/register', [RegistrationController::class, 'create'])->name('create.user');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.user');

Route::get('/forgot_password', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email');
Route::get('/password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');





