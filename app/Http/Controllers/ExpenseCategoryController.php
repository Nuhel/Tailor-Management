<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\DataTables\ExpenseCategoryDataTable;
use App\Http\Requests\ExpenseCategoryRequest;

class ExpenseCategoryController extends Controller
{

    public function index(ExpenseCategoryDataTable $dataTable)
    {
        return $dataTable->render('components.datatable.index',['heading'=>'Expense Categories']);
    }


    public function create()
    {
        return view('expense_category.create');
    }


    public function store(ExpenseCategoryRequest $request)
    {
        $expenseCategory = new ExpenseCategory();
        $expenseCategory->name = $request->name;
        return $this->redirectWithAlert($expenseCategory->save(),'expense-categories');
    }


    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }


    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('expense_category.edit')->with('expenseCategory',$expenseCategory);
    }


    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->name = $request->name;
        return $this->redirectWithAlert($expenseCategory->update(),'expense-categories');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        return $this->redirectWithAlert($expenseCategory->delete(),'expense-categories');
    }
}
