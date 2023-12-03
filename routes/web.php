<?php

use Illuminate\Support\Facades\Route;

// ! Web Routes

// Any
Route::get('{any}', function () {
    return view('application');
})->where('any', '.*');
