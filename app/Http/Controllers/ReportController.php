<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\DataTables\Reports\OrderDataTable;
use App\DataTables\Reports\PurchaseDataTable;
use App\DataTables\Reports\SaleDataTable;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function orderReport(OrderDataTable $dataTable)
    {
        return $dataTable->render('reports.order',['heading'=>'Order Report']);
    }

    public function purchaseReport(PurchaseDataTable $dataTable)
    {
        return $dataTable->render('reports.purchase',['heading'=>'Purchase Report']);
    }

    public function saleReport(SaleDataTable $dataTable)
    {
        return $dataTable->render('reports.purchase',['heading'=>'Sale Report']);
    }

    public function profitReport(SaleDataTable $dataTable)
    {
        $orders = Order::with(['products' => function($query){
            //$query->select('','order_id','');
        },'services' => function($query){
            $query->select();
        }])->select('id','invoice_no','order_date')->get();
        dd($orders->toArray());
        die();
        return $dataTable->render('reports.purchase',['heading'=>'Sale Report']);
    }

}
