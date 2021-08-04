<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('todo',[TodoController::class, 'index']);
    Route::post('todo',[TodoController::class, 'store']);
    Route::get('todo/{todo}',[TodoController::class, 'show']);
    Route::put('todo/{todo}',[TodoController::class,'update']);
    Route::delete('todo/{todo}',[TodoController::class,'destroy']);


    Route::get('user',[UserController::class, 'index']);
    Route::post('adduser',[UserController::class, 'store'])->name('user.store');
    Route::get('user/{user}',[UserController::class, 'show']);
    Route::put('user/{user}',[UserController::class,'update']);
    Route::delete('user/{user}',[UserController::class,'destroy']);

});

//Route::middleware('guest')->group(function() {
    Route::post('login', LoginController::class)->name('login');
    Route::post('register', RegisterController::class)->name('register');
//});