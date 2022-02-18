<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\ServiceDesign;
use App\Models\OrderServicDesign;
use App\Models\ServiceDesignStyle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\OrderServicMeasurement;
use App\Models\OrderService as OrderServiceModel;

class OrderService{
    public $designs;
    public $styles;
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
        $this->designs = ServiceDesign::all();
        $this->styles = ServiceDesignStyle::all();
    }

    public function storeOrder(){
        try{
            DB::beginTransaction();
            if($this->onEdit){
                $this->deleteRelatedData();
            }



            $this->order->customer_id     = $this->request->customer_id;
            $this->order->master_id       = $this->request->master_id;
            $this->order->account_id      = $this->request->account_id;
            $this->order->delivery_date   = $this->request->delivery_date;
            $this->order->trial_date      = $this->request->trial_date;
            $this->order->total           = $this->request->total;
            $this->order->discount        = $this->request->discount;
            $this->order->netpayable      = $this->request->netpayable;
            $this->order->paid            = $this->request->paid;
            $this->order->due             = $this->request->due;

            if($this->onEdit){
                $this->order->update();
            }else{
                $this->order->save();
            }

            $orderId = $this->order->id;
            collect($this->request->services)->each(function ($service) use($orderId){
                $orderService = new OrderServiceModel();
                $orderService->order_id     = $orderId;
                $orderService->service_id   = $service['service_id'];
                $orderService->employee_id  = $service['employee_id'];
                $orderService->quantity     = $service['quantity'];
                $orderService->price        = $service['price'];
                $orderService->save();
                $this->attachMeasurementsToService($orderService,collect($service['measurements']));
                $this->attachDesignToService($orderService,collect($service['designs']));
            });

            $products = collect($this->request->products)->map(function($value){
                $product = new OrderProduct();
                $product->product_id    = $value['id'];
                $product->price         = $value['price'];
                $product->quantity      = $value['quantity'];
                return $product;
            });
            $this->order->products()->saveMany($products);
            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollBack();
        }
        return false;
    }

    public function attachMeasurementsToService(OrderServiceModel $service, Collection $measurements){
        $measurements = $measurements->map(function($value){
            $measurement = new OrderServicMeasurement();
            $measurement->measurement_id    = $value['id'];
            $measurement->size              = $value['size'];
            return $measurement;
        });
        $service->serviceMeasurements()->saveMany($measurements);
    }

    public function attachDesignToService(OrderServiceModel $service, Collection $designs){
        $designs = $designs->map(function($value){

            $fallbackDesign = $this->designs->where('id',$value['id'])->first();
            $fallbackDesignName = $fallbackDesign!=null?$fallbackDesign->name:"";

            $fallbackStyle = $this->styles->where('id',$value['style_id'])->first();
            $fallbackStyleName = $fallbackStyle!=null?$fallbackStyle->name:"";

            $design                             = new OrderServicDesign();
            $design->service_design_id          = $value['id'];
            $design->design_name                = $fallbackDesignName;
            $design->service_design_style_id    = $value['style_id'];
            $design->style_name                 = $fallbackStyleName;
            return $design;
        });
        $service->serviceDesigns()->saveMany($designs);
    }

    public function deleteRelatedData(){
        $this->order->products()->delete();
        foreach($this->order->services as $service){
            $service->serviceMeasurements()->delete();
            $service->serviceDesigns()->delete();
        }
        $this->order->services()->delete();
    }

    public function delete()
    {
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
}
