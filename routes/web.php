<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;

Route::get('/', [OrderController::class,'create']);
Route::resource('/employees',EmployeeController::class);
Route::resource('/masters',MasterController::class);
Route::resource('/customers',CustomerController::class);
Route::resource('/categories',CategoryController::class);
Route::resource('/products',ProductController::class);
Route::resource('/banks',BankController::class);
Route::resource('/bank_accounts',BankAccountController::class);
Route::resource('/services',ServiceController::class);
Route::resource('/orders',OrderController::class);
