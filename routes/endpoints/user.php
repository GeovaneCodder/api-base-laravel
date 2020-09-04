<?php

use Illuminate\Support\Facades\Route;

/** Login */
Route::apiResource('user', 'UserController')
    ->middleware('auth:sanctum');
