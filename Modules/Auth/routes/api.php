<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

/*
 * --------------------------------------------------------------------------
 * API Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
 */

$apiVersion = config('app.api_version');

Route::prefix($apiVersion)->group(function () {
    Route::apiResource('auth', AuthController::class)->names('auth');
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::middleware(['auth:sanctum'])->prefix($apiVersion)->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
