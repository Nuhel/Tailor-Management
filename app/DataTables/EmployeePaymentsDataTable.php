<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\OrderService;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class EmployeePaymentsDataTable extends DataTable
{

    protected $tableId = 'employeepayments-table';

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(Request $request,$query)
    {

        return datatables()
            ->eloquent($query)
            ->addColumn('employee', function(OrderService $employeepayment) {
                return $employeepayment->employee->name;
            })->addColumn('service', function(OrderService $employeepayment) {
                return $employeepayment->service->name;
            })->addColumn('order', function(OrderService $employeepayment) {
                return $employeepayment->order->invoice_no;
            })->addColumn('due', function(OrderService $employeepayment) {
                return $employeepayment->crafting_price - $employeepayment->paid;
            })
            ->addColumn('payments', function(OrderService $employeepayment){
                $data = "<table class='table table-sm'>
                            <thead>
                                <tr>
                                    <td>Amount</td>
                                    <td>Date</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>";
                foreach($employeepayment->payments as $payment){
                    $action  = view('components.actionbuttons.table_actions')->with('route','employee-payments')->with('param','employee_payment')->with('value',$payment)->render();
                    $date = Carbon::parse($payment->transaction_date)->format('Y-m-d');
                    $data.= "
                        <tr>
                            <td>{$payment->amount}</td>
                            <td>{$date}</td>
                            <td>{$action}</td>
                        </tr>";
                }

                $data .="<tbody> </table>";
                return $data;
            })

            ->addIndexColumn()
            ->rawColumns(['actions','payments']);
    }


    public function query(OrderService $model)
    {
        return $model->newQuery()->with(['employee' => function($query){
            $query->select('name','id');
        }])->with(['service' => function($query){
            $query->select('name','id');
        }])->with(['order' => function($query){
            $query->select('invoice_no','id');
        }])->with('payments')->paid();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            Column::computed('index','SL')->width(20),
            Column::make('order'),
            Column::make('service'),
            Column::make('employee'),
            Column::make('paid'),
            Column::computed('due'),
            Column::computed('payments'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EmployeePayments_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [

        ];
    }

    public function overrideButtons(){
        return [
            'create'=>null,
            'export'=>null,
            'print'=>null,
            'reset'=>null,
            'reload'=>null,
        ];
    }
}
