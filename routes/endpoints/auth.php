<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    /** Login */
    Route::post('login', 'AuthController@login');

    /** Logout */
    Route::get('logout', 'AuthController@logout');
});
