<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function dashboard(){
        $service = Order::select('id','order_date','netpayable')
        ->whereDate('order_date', '=', today())
        ->withSum('payments as paid', 'amount')->service()->get();
        $serviceData = new Collection();
        $serviceData->total = $service->count();
        $serviceData->netpayable = $service->sum('netpayable');
        $serviceData->paid = $service->sum('paid');


        $sale = Order::select('id','order_date','netpayable')
        ->whereDate('order_date', '=', today())
        ->withSum('payments as paid', 'amount')->sale()->get();
        $saleData = new Collection();
        $saleData->total = $sale->count();
        $saleData->netpayable = $sale->sum('netpayable');
        $saleData->paid = $sale->sum('paid');

        $purchase = Purchase::select('id','purchase_date','netpayable')
        ->withSum('payments as total_paid', 'amount')->get();
        $purchaseData = new Collection();
        $purchaseData->total = $purchase->count();
        $purchaseData->netpayable = $purchase->sum('netpayable');
        $purchaseData->paid = $purchase->sum('total_paid');

        return view('dashboard.dashboard')->with([
            'serviceData' => $serviceData,
            'saleData' => $saleData,
            'purchaseData' => $purchaseData,
        ]);
    }
}
