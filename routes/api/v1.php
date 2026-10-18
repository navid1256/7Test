<?php

use Illuminate\Support\Facades\Route;
/** @var \Laravel\Lumen\Routing\Router $router  */
Route::get('/', function (): array {
    return ['api_version' => 'v1'];
});
