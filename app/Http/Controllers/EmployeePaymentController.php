<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeePaymentsDataTable;
use App\Models\Employee;
use App\Models\EmployeePayment;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeePaymentRequest;
use App\Models\OrderService;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeePaymentController extends Controller
{

    public function index(EmployeePaymentsDataTable $dataTable)
    {
        return $dataTable->render('components.datatable.index',['heading'=>'Employee Payments']);
    }


    public function create()
    {

        $orderServices = OrderService::with(['employee' => function($query){
            $query->select('name','id');
        }])->with(['service' => function($query){
            $query->select('name','id');
        }])->with(['order' => function($query){
            $query->select('invoice_no','id');
        }])->paid()->where('crafting_price','>=','paid')->get();

        return view('employee_payment.create')->with('orderServices', $orderServices);
    }


    public function store(EmployeePaymentRequest $request)
    {
        $payment = new EmployeePayment();
        $payment->transaction_date  = $request->date;
        $payment->amount            = $request->amount;
        $payment->type              = "Credit";
        $payment->description       = $request->description;
        $orderService = OrderService::find($request->order_service_id);
        return $this->redirectWithAlert($orderService->payments()->save($payment)?true:false,'employee-payments');
    }


    public function show(Transaction $employee_payment)
    {

    }

    public function edit(Transaction $employee_payment)
    {

        //dd($employee_payment->toArray());
        $orderServices = OrderService::with(['employee' => function($query){
            $query->select('name','id');
        }])->with(['service' => function($query){
            $query->select('name','id');
        }])->with(['order' => function($query){
            $query->select('invoice_no','id');
        }])->paid()->where('crafting_price','>=','paid')->get();

        return view('employee_payment.edit')->with('orderServices', $orderServices)->with('employee_payment',$employee_payment);
    }


    public function update(EmployeePaymentRequest $request, Transaction $employee_payment)
    {

        $employee_payment->transaction_date  = $request->date;
        $employee_payment->amount            = $request->amount;
        $employee_payment->type              = "Credit";
        $employee_payment->description       = $request->description;
        $employee_payment->transactionable_id = $request->order_service_id;
        return $this->redirectWithAlert($employee_payment->update(),'employee-payments');
    }


    public function destroy(Transaction $employee_payment)
    {
        return $this->redirectWithAlert($employee_payment->delete(),'employee-payments');
    }
}
