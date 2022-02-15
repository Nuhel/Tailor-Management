<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\Validator;
class BankAccountController extends Controller
{

    public function index()
    {
        return view('bank_account.index')->with('bankAccounts',BankAccount::with('bank')->get());
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

        $response = [];
        if($bankAccount->save()){
            $response['status']= 200;
            $response['message']= "Bank Account Added Successfully";
        }else{
            $response['status']= 400;
            $response['message']= "Failed To Add Bank Account";
        }

        return redirect(route('bank_accounts.index'))->with('response',$response);

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
            "card" => "nullable|string|max:100",
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

        $response = [];
        if($bankAccount->update()){
            $response['status']= 200;
            $response['message']= "Bank Account Updated Successfully";
        }else{
            $response['status']= 400;
            $response['message']= "Failed To Updated Bank Account";
        }

        return redirect(route('bank_accounts.index'))->with('response',$response);
    }


    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect(route('bank_accounts.index'));
    }
}
