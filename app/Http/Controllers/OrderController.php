<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Master;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Employee;
use App\Const\ServiceStatus;
use Illuminate\Http\Request;
use App\DataTables\OrderDataTable;
use App\Http\Requests\OrderRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\OrderPaymentRequest;
use App\Services\OrderService as ServicesOrderService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable){
        return $dataTable->render('order.index');
    }

    public function create(){


        $services = Service::with('measurements')->with('designs.styles')->get()->mapWithKeys(function ($service, $key) {
            return [$service->id => $service];
        });

        $masters = Master::all();
        return view('order.create')
        ->with('services',$services)
        ->with('json',$this->getJson($services))
        ->with('masters',$masters)
        ->with('customers',Customer::all())
        ->with('employees',Employee::all());
    }


    public function store(OrderRequest $request){

        return $this->redirectWithAlert((new ServicesOrderService(null,$request))->handelOrder());
    }

    public function show(Order $order){
        $order = ServicesOrderService::attachRelationalData($order, true)->find($order->id);
        return view('order.show')->with('order',$order);
    }

    public function edit(Order $order){
        $services = Service::with('measurements')->with('designs.styles')->get()->mapWithKeys(function ($service, $key) {
            return [$service->id => $service];
        });

        $order = ServicesOrderService::attachRelationalData($order, true)->find($order->id);

        $masters = Master::all();
        return view('order.edit')
        ->with('services',$services)
        ->with('json',$this->getJson($services))
        ->with('masters',$masters)
        ->with('customers',Customer::all())
        ->with('employees',Employee::all())
        ->with('order',$order);
    }

    public function update(OrderRequest $request, Order $order){
        return $this->redirectWithAlert((new ServicesOrderService($order,$request))->handelOrder());
    }

    public function destroy(Order $order){
        return $this->redirectWithAlert((new ServicesOrderService($order,null))->delete());
    }


    public function getJson($services){
        return str_replace("\u0022","\\\\\"",json_encode( $services,JSON_HEX_QUOT));
    }

    public function takePayment(OrderPaymentRequest $request,Order $order){
        ServicesOrderService::attachPaymentToOrder($order,$request->amount,$request->date);
        echo "Success";
    }
}
