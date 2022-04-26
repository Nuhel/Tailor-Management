<?php

namespace App\DataTables;
use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class ExpenseDataTable extends DataTable
{
    protected $tableId = "expense-datatable";
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('actions', function(Transaction $expense) {
                return view('components.actionbuttons.table_actions')->with('route','expenses')->with('param','expense')->with('value',$expense)->render();
            })
            ->addColumn('bank_details', function(Transaction $expense){
                return !$expense->sourceable?"Cash Payment":(
                    "Number: ".$expense->sourceable->number."<br>".
                    ($expense->sourceable->card?"Card: ".$expense->sourceable->card."<br>":'').
                    "Bank: ".$expense->sourceable->bank->name."<br>".
                    "Type: ".$expense->sourceable->bank->type."<br>"

                );
            })
            ->addColumn('expense_category', function($query){
                return $query->transactionable->name;
            })
            ->addIndexColumn()
            ->rawColumns(['actions','bank_details']);
    }

    public function query(Transaction $model)
    {
        return $model->newQuery()->expense()->whereTransactionableType('App\Models\ExpenseCategory')
        ->with(['sourceable'=> function($query){
            $query->select('id','bank_id','number','card')->with(['bank'=>function($query){
                $query->select('id','name','type');
            }]);
        }])
        ->with('transactionable');
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
            Column::make('amount'),
            Column::make('expense_category'),
            Column::make('transaction_date'),
            Column::computed('bank_details'),
            Column::make('description'),
            Column::computed('actions')
                  ->exportable(false)
                  ->printable(false)
                  ->width(90)
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
        return 'Expense_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Bnak',
        ];
    }
}
