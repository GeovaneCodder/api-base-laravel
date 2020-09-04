<?php

use Illuminate\Support\Facades\Route;

/**
 * @param array $endpoints
 * @return void
 * 
 * inclui um array contendo o nome do
 * arquivo de endpoints nas rotas.
 */
if (!function_exists('includeEndpoints')) {

    function includeEndpoints(array $endpoints): void
    {
        $path = base_path('routes' . DIRECTORY_SEPARATOR . 'endpoints'
            . DIRECTORY_SEPARATOR);

        $ext = '.php';

        foreach ($endpoints as $fileName) {
            $file = $path . $fileName . $ext;

            if (!file_exists($file)) {
                throw new \Exception("Route file %s not found");
            }

            include($file);
        }
    }
}

Route::prefix('V1')->namespace('V1')->group(function () {
    Route::get('me', 'UserController@me')
        ->middleware('auth:sanctum');

    $endpoints = [
        'auth',
        'user',
    ];

    includeEndpoints($endpoints);
});
