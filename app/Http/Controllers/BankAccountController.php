<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\DataTables\BanksDataTable;
use App\DataTables\BankAccountDataTable;
use Illuminate\Support\Facades\Validator;

class BankAccountController extends Controller
{


    public function index(BankAccountDataTable $dataTable)
    {

        return $dataTable->render('components.datatable.index',['heading'=>'Bank Accounts']);
        //dd($dataTable->render('bank_account.index'));
        //return $dataTable->render('bank_account.index');
    }


    public function create()
    {
        return view('bank_account.create')->with('banks',Bank::all());
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "number" => "required|string|max:100",
            "bank_id" => "required|numeric|exists:App\Models\Bank,id",
            "card" => "nullable|string|max:100",
        ]);

        if ($validator->fails()) {

            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors())
            ->with('action','modal-open');
        }
        $bankAccount = new BankAccount();
        $bankAccount->number = $request->number;
        $bankAccount->bank_id = $request->bank_id;
        $bankAccount->card = $request->card;

        return $this->redirectWithAlert($bankAccount->save(),"bank_accounts");

    }

    public function show(BankAccount $bankAccount)
    {
        return view('bank_account.show')->with('bankAccount',$bankAccount);

    }

    public function edit(BankAccount $bankAccount)
    {
        return view('bank_account.edit')->with('banks',Bank::all())->with('bankAccount',$bankAccount);
    }


    public function update(Request $request, BankAccount $bankAccount)
    {
        $validator = Validator::make($request->all(), [
            "number" => "required|string|max:100",
            "bank_id" => "required|numeric|exists:App\Models\Bank,id",
            "card" => "nullable|string|max:100|",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors())
            ->with('action','modal-open');
        }
        $bankAccount->number = $request->number;
        $bankAccount->bank_id = $request->bank_id;
        $bankAccount->card = $request->card;
        return $this->redirectWithAlert($bankAccount->update(),"bank_accounts");

    }


    public function destroy(BankAccount $bankAccount)
    {
        return $this->redirectWithAlert($bankAccount->delete(),"bank_accounts");
    }
}
