<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DataTables\BanksDataTable;

class BankController extends Controller
{

    public function index(BanksDataTable $dataTable)
    {
        return $dataTable->render('components.datatable.index',['heading'=>'Banks']);
    }


    public function create()
    {
        return view('bank.create');
    }


    public function store(Request $request)
    {

        $types = ['General Bank','Mobile Bank'];
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            'type' => [
                'required','string','max:20',Rule::in($types)
            ],
            "address" => "nullable|string|max:100",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors())
            ->with('action','modal-open');
        }

        $bank = new Bank();
        $bank->name = $request->name;
        $bank->type = $request->type;
        $bank->address = $request->address;
        $bank->save();
        return redirect(route('banks.index'));
    }


    public function show(Bank $bank)
    {
        return view('bank.show')->with('bank',$bank);
    }


    public function edit(Bank $bank)
    {
        return view('bank.edit')->with('bank',$bank);
    }

    public function update(Request $request, Bank $bank)
    {
        $types = ['General Bank','Mobile Bank'];
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            'type' => [
                'required','string','max:20',Rule::in($types)
            ],
            "address" => "nullable|string|max:100",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors())
            ->with('action','modal-open');
        }



        $bank->name = $request->name;
        $bank->type = $request->type;
        $bank->address = $request->address;
        $bank->update();
        return redirect(route('banks.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect(route('banks.index'));
    }
}
