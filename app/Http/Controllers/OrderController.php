<?php

namespace App\Http\Controllers;

use App\DataTables\OrderDataTable;
use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Master;
use App\Models\Order;
use App\Models\Service;
use App\Services\OrderService as ServicesOrderService;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable){
        return $dataTable->render('components.datatable.index',['heading'=>'Orders']);
    }


    public function create(){
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
        ->with('employees',Employee::all());
    }


    public function store(OrderRequest $request){
        (new ServicesOrderService(null,$request))->storeOrder();
        return redirect(route('orders.index'));
    }

    public function show(Order $order){
        $order = $order->load('customer')
        ->load('master')
        ->load('products.product')
        ->load(['services' => function($query){
            return $query->with('service')->with('employee')->with('serviceMeasurements.measurement')->with('serviceDesigns');
        }]);
        return view('order.show')->with('order',$order);

    }

    public function edit(Order $order){
        $services = Service::with('measurements')->with('designs.styles')->get()->mapWithKeys(function ($service, $key) {
            return [$service->id => $service];
        });

        $order = $order
        ->load('products.product')
        ->load(['services' => function($query){
            return $query->with('service')->with('employee')->with('serviceMeasurements.measurement')->with('serviceDesigns');
        }]);

        $json = str_replace("\u0022","\\\\\"",json_encode( $services,JSON_HEX_QUOT));

        $masters = Master::all();
        return view('order.edit')
        ->with('services',$services)
        ->with('json',$json)
        ->with('masters',$masters)
        ->with('customers',Customer::all())
        ->with('employees',Employee::all())
        ->with('order',$order);
    }

    public function update(OrderRequest $request, Order $order){
        (new ServicesOrderService($order,$request))->storeOrder();
        return redirect(route('orders.index'));
    }

    public function destroy(Order $order){
        (new ServicesOrderService($order,null))->delete();
        return redirect(route('orders.index'));
    }
}
