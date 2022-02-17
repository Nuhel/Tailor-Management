<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Master;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderServicDesign;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\OrderServicMeasurement;
use App\Models\ServiceDesign;
use App\Models\ServiceDesignStyle;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public $designs;
    public $styles;

    public function index()
    {

        $orders = Order::with('customer')
        ->with('products')
        ->with(['services' => function($query){
            return $query->with('service')->with('employee')->with('serviceMeasurements.measurement')->with(['serviceDesigns' => function($query){
                return $query->with('design')->with('style');
            }]);
        }])->get();
        dd($orders->toArray());
    }


    public function create()
    {
        $services = Service::with('measurements')->with('designs.styles')->get()->mapWithKeys(function ($service, $key) {
            return [$service->id => $service];
        });

        $json = str_replace("\u0022","\\\\\"",json_encode( $services,JSON_HEX_QUOT));

        $masters = Master::all();
        return view('order.create')
        ->with('services',$services)
        ->with('json',$json)
        ->with('masters',$masters)
        ->with('customers',Customer::all())
        ->with('employees',Employee::all())
        ;
    }


    public function store(OrderRequest $request)
    {
        //Load Up the design and styles to provide fallback name
        $this->designs = ServiceDesign::all();
        $this->styles = ServiceDesignStyle::all();

        try{
            DB::beginTransaction();
            $order = new Order();
            $order->customer_id     = $request->customer_id;
            $order->master_id       = $request->master_id;
            $order->account_id      = $request->account_id;
            $order->delivery_date   = $request->delivery_date;
            $order->total           = $request->total;
            $order->discount        = $request->discount;
            $order->netpayable      = $request->netpayable;
            $order->paid            = $request->paid;
            $order->due             = $request->due;
            $order->save();

            collect($request->services)->each(function ($service) use($order){
                $orderService = new OrderService();
                $orderService->order_id     = $order->id;
                $orderService->service_id   = $service['service_id'];
                $orderService->employee_id  = $service['employee_id'];
                $orderService->quantity     = $service['quantity'];
                $orderService->price        = $service['price'];
                $orderService->save();
                $this->attachMeasurementsToService($orderService,collect($service['measurements']));
                $this->attachDesignToService($orderService,collect($service['designs']));
            });

            $products = collect($request->products)->map(function($value){
                $product = new OrderProduct();
                $product->product_id    = $value['id'];
                $product->price         = $value['price'];
                $product->quantity      = $value['quantity'];
                return $product;
            });
            $order->products()->saveMany($products);


            DB::commit();
        }catch(\Exception $e){
            dd($e);
            DB::rollBack();
        }

        return redirect()->back()->withInput();


    }

    public function attachMeasurementsToService(OrderService $service, Collection $measurements){
        $measurements = $measurements->map(function($value){
            $measurement = new OrderServicMeasurement();
            $measurement->measurement_id    = $value['id'];
            $measurement->size              = $value['size'];
            return $measurement;
        });
        $service->serviceMeasurements()->saveMany($measurements);
    }
    public function attachDesignToService(OrderService $service, Collection $designs){
        //$this->designs
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


    public function show(Order $order)
    {
        $order = $order->load('customer')
        ->load('master')
        ->load('products.product')
        ->load(['services' => function($query){
            return $query->with('service')->with('employee')->with('serviceMeasurements.measurement')->with('serviceDesigns');
        }]);
        //dd($order->toArray());
        return view('order.show')->with('order',$order);

    }


    public function edit(Order $order)
    {
        //
    }


    public function update(OrderRequest $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
