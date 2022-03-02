<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ProductionController;

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/', [OrderController::class,'create'])->name('dashboard');
    Route::resource('/employees',EmployeeController::class);
    Route::resource('/masters',MasterController::class);
    Route::resource('/customers',CustomerController::class);
    Route::resource('/categories',CategoryController::class);
    Route::resource('/products',ProductController::class);
    Route::get('/manage-stock', [ProductController::class, 'manageStock'])->name('manageStock');
    Route::post('/manage-stock', [ProductController::class, 'updateStock'])->name('updateStock');
    Route::resource('/banks',BankController::class);
    Route::resource('/bank_accounts',BankAccountController::class);
    Route::resource('/services',ServiceController::class);
    Route::resource('/orders',OrderController::class);
    Route::post('orders/{order}/take-payment',[OrderController::class,'takePayment']);
    Route::get('orders/{order}/invoice',[OrderController::class,'makeInvoice'])->name('makeInvoice');

    Route::controller(ProductionController::class)->group(function(){
        Route::get('productions','index')->name('productions.index');
        Route::get('productions/pending', 'pendingDataTable')->name('productions.pending');
        Route::get('productions/processing','processingDataTable')->name('productions.processing');
        Route::get('productions/delivard','readyDataTable')->name('productions.ready');
        Route::post('productions/sent-to-production/{orderService}','sentToProduction')->name('productions.sentToProduction');
        Route::post('productions/make-ready/{orderService}','makeReady')->name('productions.makeReady');
    });

});





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
