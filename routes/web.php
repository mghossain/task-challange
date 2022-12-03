<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;



Route::resource('/', CustomerController::class);


Route::post('numvalidate', ValidationController::class);
