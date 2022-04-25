<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\PurchaseService;
use App\DataTables\PurchaseDataTable;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\PurchasePaymentRequest;

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


        $purchase = (new PurchaseService(null,$request))->handelPurchase();

        if($purchase && ($request->print == 'true')){
            //return redirect(route('makeInvoice',['purchase'=>$purchase]));
        }else{
            return $this->redirectWithAlert($purchase?true:false);
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

    public function takePayment(PurchasePaymentRequest $request,Purchase $purchase){
        PurchaseService::attachPaymentToPurchase($purchase,$request->amount,$request->date);
        echo "Success";
    }

    public function makeInvoice(Purchase $purchase){
        $purchase = PurchaseService::attachRelationalData($purchase, true)->find($purchase->id);
        return view('purchase.invoice.invoice')->with('purchase',$purchase);
    }
}
