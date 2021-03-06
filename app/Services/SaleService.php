<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\ServiceDesign;
use Illuminate\Support\Carbon;
use App\Constant\ServiceStatus;
use App\Models\OrderServicDesign;
use App\Models\ServiceDesignStyle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\OrderServicMeasurement;
use Illuminate\Database\Eloquent\Builder;
use App\Models\OrderService as OrderServiceModel;
use App\Models\Service;
use Mavinoo\Batch\BatchFacade as Batch;

class SaleService{

    public Order $order;
    public $request;
    private  bool $onEdit = false;
    public function __construct(Order $order = null,Request $request = null)
    {   $this->request = $request;
        if($order == null){
            $this->order = new Order();

        }else{
            $this->order = $order;
            $this->onEdit = true;
        }
    }

    public function handelOrder(){
        try{

            DB::beginTransaction();

            if($this->onEdit){
                $this->loadPayments();
                $this->deleteRelatedData();
            }
            $this->order->customer_id     = $this->request->customer_id;
            $this->order->invoice_no      = $this->order->invoice_no??$this->getInvoiceNumber();
            $this->order->master_id       = null;
            $this->order->account_id      = $this->request->account_id;
            $this->order->delivery_date   = $this->request->order_date;
            $this->order->trial_date      = null;
            $this->order->order_date      = $this->request->order_date;
            $this->order->total           = $this->request->total;
            $this->order->discount        = $this->request->discount;
            $this->order->netpayable      = $this->request->netpayable;
            $this->order->initially_paid  = $this->request->paid;
            $this->order->initial_due     = $this->request->due;
            $this->order->is_sale         = 1;

            if($this->onEdit){
                $this->order->update();
            }else{
                $this->order->save();
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
                $product = new OrderProduct();
                $product->product_id    = $value['id'];
                $product->price         = $value['price'];
                $product->supplier_price    = $value['supplier_price'];
                $product->quantity      = $value['quantity'];

                $productStockUpdate[] = [
                    'id' => $value['id'],
                    'stock' => ['-', $value['quantity'] ],
                ];

                return $product;
            });

            if( $products != null && count($products) && $products[0] != null){
                $this->order->products()->saveMany($products);
                Batch::update(new Product(), $productStockUpdate, 'id');
            }


            DB::commit();
            return $this->order;
        }catch(\Exception $e){
            dd($e);
            DB::rollBack();
        }
        return false;
    }


    public function restockSoldProducts(){
        $productStockUpdate = [];
            $this->order->products->each(function($val,$index) use(&$productStockUpdate){
                $productStockUpdate[] = [
                    'id' =>$val->product_id,
                    'stock' => ['+', $val->quantity,],
                ];
            });
            if(count($productStockUpdate)){
                Batch::update(new Product(), $productStockUpdate, 'id');
            }
            //$sale->details()->delete();
    }

    public function deleteRelatedData(){
        $this->restockSoldProducts();
        $this->order->products()->delete();
    }

    public function loadPayments(){
        $this->order = Order::paid()->find($this->order->id);
    }

    public function delete(){
        try{
            DB::beginTransaction();
            $this->deleteRelatedData();
            $this->order->delete();
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
            $previouslyPaid =  $this->order->paid;
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
        return self::attachPaymentToOrder($this->order, $amount,null, $account_id);
    }

    /**
     * Attach Payment To Order
     *
     * @param  \App\Models\Order  $order
     * @param  double  $amount
     * @param  mixed  $date
     * @return bool
     */

    static function attachPaymentToOrder(Order $order, $amount,$date = null, $account_id){
        $payment = new Transaction();
        $payment->transaction_date  = $date??$order->order_date;
        $payment->amount            = $amount;
        $payment->type              = "Debit";
        $payment->description       = "Paid To Order";
        if($account_id != null){
            $payment->sourceable_type = 'App\Models\BankAccount';
            $payment->sourceable_id = $account_id;
        }
        return $order->payments()->save($payment);
    }

    static function attachRelationalData(Order $order, bool $withTransactions = false):Builder{
        $order =  $order->with('customer')
        ->with('products.product');
        if($withTransactions)
            $order = $order->paid();
        return $order;
    }


    public function getInvoiceNumber(){
        $count =  Order::whereDate('created_at', '=', Carbon::today())->count();
        return "INV-".Carbon::today()->format('y-m-d')."-".str_pad($count+1, 3, "0", STR_PAD_LEFT);
    }
}
