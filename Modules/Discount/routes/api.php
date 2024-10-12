<?php

use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\ApplicationController;
use Modules\Discount\Http\Controllers\BookingController;
use Modules\Discount\Http\Controllers\DiscountController;

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

Route::middleware(['auth:sanctum'])->prefix($apiVersion)->group(function () {
    Route::apiResource('application', ApplicationController::class)->names('application');
});

Route::prefix($apiVersion)->group(function () {
    Route::apiResource('booking', BookingController::class)->names('booking');
});

Route::middleware(['auth:sanctum', 'admin.access'])->prefix($apiVersion)->group(function () {
    Route::apiResource('discount', DiscountController::class)->names('discount');
});

