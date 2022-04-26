<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\PurchaseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Mavinoo\Batch\BatchFacade as Batch;

class PurchaseService{

    public Purchase $purchase;
    public $request;
    private  bool $onEdit = false;
    public function __construct(Purchase $purchase = null,Request $request = null)
    {   $this->request = $request;
        if($purchase == null){
            $this->purchase = new Purchase();

        }else{
            $this->purchase = $purchase;
            $this->onEdit = true;
        }
    }

    public function handelPurchase(){
        try{

            DB::beginTransaction();

            if($this->onEdit){
                $this->loadPayments();
                $this->deleteRelatedData();
            }
            $this->purchase->supplier_id     = $this->request->supplier_id;
            $this->purchase->invoice_no      = $this->purchase->invoice_no??$this->getInvoiceNumber();
            $this->purchase->purchase_date   = $this->request->purchase_date;
            $this->purchase->total           = $this->request->total;
            $this->purchase->discount        = $this->request->discount;
            $this->purchase->netpayable      = $this->request->netpayable;
            $this->purchase->initially_paid  = $this->request->paid;
            $this->purchase->initial_due     = $this->request->due;
            if($this->onEdit){
                $this->purchase->update();
            }else{
                $this->purchase->save();
            }
            $amountToAttach = $this->getPaymentAmount();
            if($amountToAttach){
                $this->attachPayment($amountToAttach,$this->request->account_id);
            }else if(!$this->onEdit){
                $this->attachPayment(0,$this->request->account_id);
            }


            $productStockUpdate = array();
            $products = collect($this->request->products)->map(function($value) use(&$productStockUpdate){
                if($value == null)
                    return null;
                $product = new PurchaseProduct();
                $product->product_id    = $value['id'];
                $product->price         = $value['price'];
                $product->quantity      = $value['quantity'];

                $productStockUpdate[] = [
                    'id' => $value['id'],
                    'stock' => ['+', $value['quantity'] ],
                ];
                return $product;
            });

            if( $products != null && count($products) && $products[0] != null){
                $this->purchase->products()->saveMany($products);
                Batch::update(new Product(), $productStockUpdate, 'id');
            }
            DB::commit();
            return $this->purchase;
        }catch(\Exception $e){
            dd($e);
            DB::rollBack();
        }
        return false;
    }


    public function restockPurchasedProducts(){
        $productStockUpdate = [];
            $this->purchase->products->each(function($val,$index) use(&$productStockUpdate){
                $productStockUpdate[] = [
                    'id' =>$val->product_id,
                    'stock' => ['-', $val->quantity,],
                ];
            });
            if(count($productStockUpdate)){
                Batch::update(new Product(), $productStockUpdate, 'id');
            }
            //$sale->details()->delete();
    }

    public function deleteRelatedData(){
        $this->restockPurchasedProducts();
        $this->purchase->products()->delete();
    }

    public function loadPayments(){
        $this->purchase = Purchase::paid()->find($this->purchase->id);
    }

    public function delete(){
        try{
            DB::beginTransaction();
            $this->deleteRelatedData();
            $this->purchase->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){

            DB::rollBack();
        }
        return false;
    }

    public function getPaymentAmount(){
        $previouslyPaid =  0;
        if($this->onEdit){
            $previouslyPaid =  $this->purchase->paid;
            $payable = $this->request->netpayable;
            $returnAmount = 0;
            if($previouslyPaid > $payable){
                $returnAmount = $previouslyPaid - $payable;
            }
            $newlyPaid = $this->request->paid - $previouslyPaid;
            if($returnAmount > 0){
                return  -1 * abs($returnAmount);
            }else if(isset($newlyPaid) ){
                return$newlyPaid;
            }else{
                return null;
            }
        }else{
            return $this->request->paid;
        }
    }

    public function attachPayment($amount,$account_id){
        return self::attachPaymentToPurchase($this->purchase, $amount,null,$account_id);
    }


    static function attachPaymentToPurchase(Purchase $purchase, $amount,$date = null, $account_id){
        $payment = new Transaction();
        $payment->transaction_date  = $date??$purchase->purchase_date;
        $payment->amount            = $amount;
        $payment->type              = "Credit";
        $payment->description       = "Paid To Purchase";
        if($account_id != null){
            $payment->sourceable_type = 'App\Models\BankAccount';
            $payment->sourceable_id = $account_id;
        }
        return $purchase->payments()->save($payment);
    }

    static function attachRelationalData(Purchase $purchase, bool $withTransactions = false):Builder{
        $purchase =  $purchase->with('supplier')
        ->with('products.product');
        if($withTransactions)
            $purchase = $purchase->paid();
        return $purchase;
    }


    public function getInvoiceNumber(){
        $count =  Purchase::whereDate('created_at', '=', Carbon::today())->count();
        return "INVS-".Carbon::today()->format('y-m-d')."-".str_pad($count+1, 3, "0", STR_PAD_LEFT);
    }
}
