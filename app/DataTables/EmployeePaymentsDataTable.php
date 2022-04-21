<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\EmployeePayment;
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
            ->addColumn('employee', function(EmployeePayment $employeepayment) {
                return $employeepayment->employee->name;
            })
            ->addColumn('actions', function(EmployeePayment $employeepayment) {
                return view('components.actionbuttons.table_actions')->with('route','employee-payments')->with('param','employee_payment')->with('value',$employeepayment)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EmployeePayment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmployeePayment $model)
    {
        return $model->newQuery()->with('employee');
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
            Column::make('employee'),
            Column::make('amount'),
            Column::make('transaction_date'),
            Column::make('description'),
            Column::computed('actions')
                  ->exportable(false)
                  ->printable(false)
                  ->width(240)
                  ->addClass('text-center')

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
