<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/phpinfo', function () {
    return view('system.phpinfo');
});

Route::get('/optimize', function () {
    return view('system.optimize');
});

Route::fallback(function () {
    return view('errors.404');
});
