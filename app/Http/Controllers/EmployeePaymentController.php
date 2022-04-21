<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeePaymentsDataTable;
use App\Models\Employee;
use App\Models\EmployeePayment;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeePaymentRequest;
use Illuminate\Support\Carbon;

class EmployeePaymentController extends Controller
{

    public function index(EmployeePaymentsDataTable $dataTable)
    {
        return $dataTable->render('components.datatable.index',['heading'=>'Employee Payments']);
    }


    public function create()
    {
        return view('employee_payment.create')->with('employees', Employee::all());
    }


    public function store(EmployeePaymentRequest $request)
    {

        $payment = new EmployeePayment();
        $payment->transaction_date  = $request->date;
        $payment->amount            = $request->amount;
        $payment->type              = "Credit";
        $payment->description       = $request->description;
        $craftsMan = Employee::find($request->craftsman_id);


        return $this->redirectWithAlert($craftsMan->payments()->save($payment)?true:false,'employee-payments');
    }


    public function show(EmployeePayment $employee_payment)
    {

    }

    public function edit(EmployeePayment $employee_payment)
    {

        return view('employee_payment.edit')->with('employees', Employee::all())->with('employee_payment',$employee_payment);
    }


    public function update(EmployeePaymentRequest $request, EmployeePayment $employee_payment)
    {

        $employee_payment->transaction_date  = $request->date;
        $employee_payment->amount            = $request->amount;
        $employee_payment->type              = "Credit";
        $employee_payment->description       = $request->description;
        $employee_payment->transactionable_id = $request->craftsman_id;
        return $this->redirectWithAlert($employee_payment->update(),'employee-payments');
    }


    public function destroy(EmployeePayment $employee_payment)
    {
        return $this->redirectWithAlert($employee_payment->delete(),'employee-payments');
    }
}
