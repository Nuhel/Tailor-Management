<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\DataTables\PurchaseDataTable;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\OrderPaymentRequest;
use App\Services\PurchaseService;

class PurchaseController extends Controller
{
    public function index(PurchaseDataTable $dataTable){
        return $dataTable->render('purchase.index');
    }

    public function create(){
        return view('purchase.create')
        ->with('suppliers',Supplier::all());
    }

    public function store(PurchaseRequest $request){


        $order = (new PurchaseService(null,$request))->handelPurchase();

        if($order && ($request->print == 'true')){
            //return redirect(route('makeInvoice',['order'=>$order]));
        }else{
            return $this->redirectWithAlert($order?true:false);
        }
    }

    public function show(Purchase $purchase){
        $purchase = PurchaseService::attachRelationalData($purchase, true)->find($purchase->id);
        return view('purchase.show')->with('purchase',$purchase);
    }

    public function edit(Purchase $purchase){
        $purchase = PurchaseService::attachRelationalData($purchase, true)->find($purchase->id);

        return view('purchase.edit')
        ->with('suppliers',Supplier::all())
        ->with('purchase',$purchase);
    }

    public function update(PurchaseRequest $request, Purchase $purchase){
        return $this->redirectWithAlert((new PurchaseService($purchase,$request))->handelPurchase()?true:false);
    }

    public function destroy(Purchase $purchase){
        return $this->redirectWithAlert((new PurchaseService($purchase,null))->delete());
    }

    public function takePayment(OrderPaymentRequest $request,Purchase $purchase){
        PurchaseService::attachPaymentToOrder($purchase,$request->amount,$request->date);
        echo "Success";
    }

    public function makeInvoice(Purchase $purchase){
        $purchase = PurchaseService::attachRelationalData($purchase, true)->find($purchase->id);
        return view('order.invoice.invoice')->with('order',$purchase);
    }
}
