<?php

namespace App\Http\Controllers;

use App\DataTables\SupplierDataTable;
use App\Http\Requests\BasicPersonRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Traits\BasicPersonTrait;

class SupplierController extends Controller
{
    use BasicPersonTrait;

    public function index(SupplierDataTable $dataTable){
        return $dataTable->render('components.datatable.index',['heading'=>'Suppliers']);
    }

    public function create(){
        return view('basic_person.create')->with([
            'route' => route('suppliers.store'),
            'personRole' => "Supplier"
        ]);
    }




    public function store(BasicPersonRequest $request)
    {
        $supplier = new Supplier();
        $this->storePerson($request,$supplier);

        if($request->wantsJson()){
            return response($supplier->toJson());
        }else{
            return $this->redirectWithAlert();
        }
        return redirect(route('suppliers.index'));
    }


    public function show(Supplier $supplier){

    }


    public function edit(Supplier $supplier){
        return view('basic_person.edit')->with([
            'route' => route('suppliers.update',  ['supplier'=> $supplier]),
            'personRole' => "Supplier"
        ])->with('person',$supplier);
    }


    public function update(BasicPersonRequest $request, Supplier $supplier){
        return $this->redirectWithAlert($this->updatePerson($request,$supplier));
    }


    public function destroy(Supplier $supplier){
        //return $this->redirectWithAlert(false,null,'Sorry You Have Purchsed From This Supplier');
        return $this->redirectWithAlert($supplier->delete());
    }
}
