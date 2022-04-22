<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Services\SaleService;
use App\DataTables\SaleDataTable;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\OrderPaymentRequest;


class SaleController extends Controller
{
    public function index(SaleDataTable $dataTable){
        return $dataTable->render('sale.index');
    }

    public function create(){
        return view('sale.create')
        ->with('customers',Customer::all());
    }


    public function store(SaleRequest $request){
        $order = (new SaleService(null,$request))->handelOrder();
        if($order && ($request->print == 'true')){
            return redirect(route('makeInvoice',['order'=>$order]));
        }else{
            return $this->redirectWithAlert($order?true:false);
        }
    }

    public function show(Order $sale){
        $sale = SaleService::attachRelationalData($sale, true)->find($sale->id);
        return view('sale.show')->with('order',$sale);
    }

    public function edit(Order $sale){
        $sale = SaleService::attachRelationalData($sale, true)->find($sale->id);

        return view('sale.edit')
        ->with('customers',Customer::all())
        ->with('order',$sale);
    }

    public function update(SaleRequest $request, Order $sale){
        return $this->redirectWithAlert((new SaleService($sale,$request))->handelOrder());
    }

    public function destroy(Order $sale){
        return $this->redirectWithAlert((new SaleService($sale,null))->delete());
    }

    public function takePayment(OrderPaymentRequest $request,Order $sale){
        SaleService::attachPaymentToOrder($sale,$request->amount,$request->date);
        echo "Success";
    }

    public function makeInvoice(Order $sale){
        $sale = SaleService::attachRelationalData($sale, true)->find($sale->id);
        return view('order.invoice.invoice')->with('order',$sale);
    }
}
