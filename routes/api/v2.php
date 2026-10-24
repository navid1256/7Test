<?php

use App\Http\Controllers\API\V2\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): array {
    return ['api_version' => 'v2'];
});

Route::post('/users', [UsersController::class, 'store']);

