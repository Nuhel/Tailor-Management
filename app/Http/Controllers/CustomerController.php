<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(CustomerDataTable $customerDataTable)
    {
        return $customerDataTable->render('customer.index');
    }


    public function create()
    {
        return view('customer.create');
    }


    public function store(CustomerRequest $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        $customer->save();

        if($request->wantsJson()){
            return response($customer->toJson());
        }
        return redirect(route('customers.index'));
    }

    public function show(Customer $customer)
    {
        return view('customer.show')->with('customer',$customer);
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit')->with('customer',$customer);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        $customer->update();
        return redirect(route('customers.index'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect(route('customers.index'));
    }
}
