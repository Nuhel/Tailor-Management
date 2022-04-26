<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeePaymentController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;


Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/', [OrderController::class,'create']);
    Route::resource('/employees',EmployeeController::class);
    Route::resource('/employee-payments',EmployeePaymentController::class);
    Route::resource('/masters',MasterController::class);
    Route::resource('/customers',CustomerController::class);
    Route::resource('/suppliers',SupplierController::class);
    Route::resource('/categories',CategoryController::class);
    Route::resource('/products',ProductController::class);
    Route::get('/manage-stock', [ProductController::class, 'manageStock'])->name('manageStock');
    Route::post('/manage-stock', [ProductController::class, 'updateStock'])->name('updateStock');
    Route::resource('/banks',BankController::class);
    Route::resource('/bank_accounts',BankAccountController::class);
    Route::resource('/services',ServiceController::class);
    Route::resource('/orders',OrderController::class);
    Route::resource('/expense-categories',ExpenseCategoryController::class);
    Route::resource('/expenses',ExpenseController::class);

    Route::post('orders/{order}/take-payment',[OrderController::class,'takePayment']);
    Route::get('orders/{order}/invoice',[OrderController::class,'makeInvoice'])->name('makeInvoice');

    Route::resource('/sales',SaleController::class);
    Route::resource('/purchases',PurchaseController::class);
    Route::post('purchases/{purchase}/take-payment',[PurchaseController::class,'takePayment']);
    Route::get('purchases/{purchase}/invoice',[PurchaseController::class,'makeInvoice'])->name('purchase-invoice');


    Route::controller(ProductionController::class)->group(function(){
        Route::get('productions','index')->name('productions.index');
        Route::get('productions/pending', 'pendingDataTable')->name('productions.pending');
        Route::get('productions/processing','processingDataTable')->name('productions.processing');
        Route::get('productions/delivard','readyDataTable')->name('productions.ready');
        Route::post('productions/sent-to-production/{orderService}','sentToProduction')->name('productions.sentToProduction');
        Route::post('productions/make-ready/{orderService}','makeReady')->name('productions.makeReady');
    });

    Route::get('order-report',[ReportController::class,'orderReport'])->name('order-report');
    Route::get('purchase-report',[ReportController::class,'purchaseReport'])->name('purchase-report');
    Route::get('sale-report',[ReportController::class,'saleReport'])->name('sale-report');
    Route::get('profit-report',[ReportController::class,'profitReport'])->name('profit-report');

    Route::get('dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('/transactions',[TransactionController::class,'index'])->name('transactions.index');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
