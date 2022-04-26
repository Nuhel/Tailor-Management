<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseDataTable;
use App\Models\Transaction;
use App\Models\ExpenseCategory;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    public function index(ExpenseDataTable $datatable){
        return $datatable->render('components.datatable.index',['heading'=>'Expenses']);
    }

    public function create()
    {
        return view('expenses.create')->with('expenseCategories', ExpenseCategory::all());
    }

    public function store(ExpenseRequest $request)
    {
        $payment = new Transaction();
        $payment->transaction_date  = $request->date;
        $payment->amount            = $request->amount;
        $payment->type              = "Credit";
        $payment->description       = $request->description??"Expense";
        $payment->transactionable_type = 'App\Models\ExpenseCategory';
        $payment->transactionable_id = $request->expense_category_id;
        if($request->account_id != null){
            $payment->sourceable_type = 'App\Models\BankAccount';
            $payment->sourceable_id = $request->account_id;
        }
        return $this->redirectWithAlert($payment->save());
    }

    public function show(Transaction $expense){}

    public function edit(Transaction $expense){
        $expense = $expense->load('sourceable');
        $bankType = $expense->has('sourceable')?$expense->sourceable->bank->type:"Cash Payment";
        $bankId = $expense->has('sourceable')?$expense->sourceable->bank->id:"";
        return view('expenses.edit')->with('expenseCategories', ExpenseCategory::all())->with([
            'expense' => $expense,
            'bankType' => $bankType,
            'bankId' => $bankId,
        ]);
    }

    public function update(ExpenseRequest $request,Transaction $expense){
        $expense->transaction_date  = $request->date;
        $expense->amount            = $request->amount;
        $expense->type              = "Credit";
        $expense->description       = $request->description??"Expense";
        $expense->transactionable_type = 'App\Models\ExpenseCategory';
        $expense->transactionable_id = $request->expense_category_id;
        if($request->account_id != null){
            $expense->sourceable_type = 'App\Models\BankAccount';
            $expense->sourceable_id = $request->account_id;
        }else{
            $expense->sourceable_type = null;
            $expense->sourceable_id = null;
        }
        return $this->redirectWithAlert($expense->update());
    }
}
