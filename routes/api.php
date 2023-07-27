<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('user.logout');
    Route::get('/auth_user', 'authUser')->middleware('auth:sanctum')->name('user.auth_show');
    Route::put('/subscribe', 'subscribe')->middleware('auth:sanctum')->name('subscribe.update');
});

Route::apiResource('users', UserController::class)->middleware('auth:sanctum')->except(['store']);

Route::post('users', [UserController::class, 'store']);

