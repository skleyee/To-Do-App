<?php

use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks');;
    Route::post('/tasks', [TaskController::class, 'store'])->name('create.task');
    Route::get('tasks/{id}', [TaskController::class, 'show'])->name('show.task');
    Route::put('tasks/{id}', [TaskController::class, 'update'])->name('update.task');
    Route::delete('tasks/{id}', [TaskController::class, 'destroy'])->name('delete.task');
});

Route::middleware(['guest:sanctum'])->group(function () {
    Route::post('register', [RegistrationController::class, 'register'])->name('register');
    Route::post('login', [RegistrationController::class, 'login'])->name('login');
});

