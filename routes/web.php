<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return File::get(public_path('index.html'));
});
