<?php

namespace App\Http\Controllers;

use App\DataTables\CustomerDataTable;
use App\Http\Requests\BasicPersonRequest;
use App\Models\Customer;
use App\Http\Traits\BasicPersonTrait;
class CustomerController extends Controller
{
    use BasicPersonTrait;
    public function index(CustomerDataTable $customerDataTable)
    {
        return $customerDataTable->render('customer.index');
    }


    public function create()
    {
        return view('basic_person.create')->with([
            'route' => route('customers.store'),
            'personRole' => "Customer"
        ]);
    }


    public function store(BasicPersonRequest $request)
    {
        $customer = new Customer();
        $this->storePerson($request,$customer);

        if($request->wantsJson()){
            return response($customer->toJson());
        }else{
            return $this->redirectWithAlert();
        }
        return redirect(route('customers.index'));
    }

    public function show(Customer $customer)
    {
        return view('customer.show')->with('customer',$customer);
    }

    public function edit(Customer $customer)
    {
        return view('basic_person.edit')->with([
            'route' => route('customers.update',  ['customer'=> $customer]),
            'personRole' => "Customer"
        ])->with('person',$customer);
    }

    public function update(BasicPersonRequest $request, Customer $customer)
    {
        return $this->redirectWithAlert($this->updatePerson($request,$customer));
    }

    public function destroy(Customer $customer)
    {
        return $this->redirectWithAlert($customer->delete());
    }
}
