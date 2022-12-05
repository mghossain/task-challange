<?php

use App\Http\Controllers\CustomerControllerAPI;
use Illuminate\Support\Facades\Route;


Route::get('/users', [CustomerControllerAPI::class, 'index'])->name('index');
Route::get('/users/{customer}', [CustomerControllerAPI::class, 'show'])->name('show');

Route::post('/users/create', [CustomerControllerAPI::class, 'store'])->name('store');
Route::get('/create', [CustomerControllerAPI::class, 'create'])->name('create');

Route::get('/users/{customer}/edit', [CustomerControllerAPI::class, 'edit'])->name('edit');
Route::patch('/users/{customer}', [CustomerControllerAPI::class, 'update'])->name('update');

Route::delete('/users/{customer}', [CustomerControllerAPI::class, 'destroy'])->name('destroy');



//Route::post('numvalidate', ValidationController::class);

