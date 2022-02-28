<?php

namespace App\Http\Controllers;

use App\DataTables\MasterDataTable;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MasterDataTable $masterDataTable)
    {
        return $masterDataTable->render('components.datatable.index',['heading'=>'Masters']);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            "mobile" => "required|string|max:100",
            "address" => "required|string|max:500",
            "salary" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors())
            ->with('action','modal-open');
        }
        $master = new Master();
        $master->name = $request->name;
        $master->mobile = $request->mobile;
        $master->address = $request->address;
        $master->salary = $request->salary;
        return $this->redirectWithAlert($master->save());
    }


    public function show(Master $master)
    {
        return view('master.show')->with('master',$master);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function edit(Master $master)
    {
        return view('master.edit')->with('master',$master);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Master $master)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            "mobile" => "required|string|max:100",
            "address" => "required|string|max:500",
            "salary" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors())
            ->with('action','modal-open');
        }
        $master->name = $request->name;
        $master->mobile = $request->mobile;
        $master->address = $request->address;
        $master->salary = $request->salary;
        return $this->redirectWithAlert($master->update());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy(Master $master)
    {
        return $this->redirectWithAlert($master->delete());
    }
}
