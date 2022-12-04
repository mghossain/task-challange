<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerControllerAPI;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;


//Route::resource('/', CustomerControllerAPI::class);

Route::get('/users', [CustomerController::class, 'index']);

Route::get('/users/create', [CustomerController::class, 'create']);
Route::post('/users/create', [CustomerController::class, 'store']);

Route::get('/users/{customer}/edit', [CustomerController::class, 'edit']);
//Route::patch('/users/{customer}', [CustomerController::class, 'update']);






Route::post('numvalidate', ValidationController::class);
