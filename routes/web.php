<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [CustomerController::class , 'index']);

Route::post('numvalidate', ValidationController::class);


