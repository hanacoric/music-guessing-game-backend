<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response('Laravel is running!');
});
