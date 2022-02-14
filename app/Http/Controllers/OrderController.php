<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Master;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {

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
        ->with('customers',Customer::all());
    }


    public function store(OrderRequest $request)
    {
        //return redirect()->back()->withInput();
        $request->dd();
    }


    public function show(Order $order)
    {
        //
    }


    public function edit(Order $order)
    {
        //
    }


    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
