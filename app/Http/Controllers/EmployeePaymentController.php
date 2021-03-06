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
        }])
        //->withSum('payments as paid', 'amount')
        ->withSum([
            'payments as paid' => fn ($query) => $query->select(DB::raw('COALESCE(SUM(amount), 0)')),
        ], 'amount')
        ->havingRaw('paid < order_services.total_crafting_price')
        ->get();

        //dd($orderServices->toArray());
        return view('employee_payment.create')->with('orderServices', $orderServices);
    }


    public function store(EmployeePaymentRequest $request)
    {
        $payment = new EmployeePayment();
        $payment->transaction_date  = $request->date;
        $payment->amount            = $request->amount;
        $payment->type              = "Credit";
        $payment->description       = $request->description;
        if($request->account_id != null){
            $payment->sourceable_type = 'App\Models\BankAccount';
            $payment->sourceable_id = $request->account_id;
        }
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
        }])
        ->withSum('payments as paid', 'amount')
        ->havingRaw('paid < order_services.total_crafting_price or order_services.id = '. $employee_payment->transactionable_id)
        ->get();


        $employee_payment->load(['sourceable' => function($query){
            $query->select('id','bank_id')->with(['bank' => function($query){
                $query->select('id','type');
            }]);
        }]);
        $bankType = "Cash Payment";
        $bankId = "";

        if( $employee_payment->has('sourceable') && ($employee_payment->sourceable != null) && ($employee_payment->sourceable->bank != null)){
            $bankType = $employee_payment->has('sourceable')?$employee_payment->sourceable->bank->type:"Cash Payment";
            $bankId = $employee_payment->has('sourceable')?$employee_payment->sourceable->bank->id:"";
        }



       //sourceable_id

        return view('employee_payment.edit')->with('orderServices', $orderServices)->with([
            'employee_payment' => $employee_payment,
            'bankType' => $bankType,
            'bankId' => $bankId,
        ]);
    }


    public function update(EmployeePaymentRequest $request, Transaction $employee_payment)
    {

        $employee_payment->transaction_date  = $request->date;
        $employee_payment->amount            = $request->amount;
        $employee_payment->type              = "Credit";
        $employee_payment->description       = $request->description;
        $employee_payment->transactionable_id = $request->order_service_id;
        if($request->account_id != null){
            $employee_payment->sourceable_type = 'App\Models\BankAccount';
            $employee_payment->sourceable_id = $request->account_id;
        }
        return $this->redirectWithAlert($employee_payment->update(),'employee-payments');
    }


    public function destroy(Transaction $employee_payment)
    {
        return $this->redirectWithAlert($employee_payment->delete(),'employee-payments');
    }
}
