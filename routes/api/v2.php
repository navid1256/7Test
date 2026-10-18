<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function (): array {
    return ['api_version' => 'v2'];
});

