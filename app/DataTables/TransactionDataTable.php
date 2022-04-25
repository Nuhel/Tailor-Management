<?php

namespace App\DataTables;
use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class TransactionDataTable extends DataTable
{
    protected $tableId = "transaction-table";
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('transaction_method', function(Transaction $transaction) {
                return $transaction->sourceable == null? "Cash Payment":
                $transaction->sourceable->bank->name . "<br>Number: {$transaction->sourceable->number}".(
                    $transaction->sourceable->card? "<br>Card: ".$transaction->sourceable->card:""
                );
            })
            ->addIndexColumn()
            ->rawColumns(['actions','transaction_method']);
    }

    public function query(Transaction $model)
    {
        return $model->newQuery()->with(['sourceable' => function($query){
            $query->select('id','bank_id','number','card')->with(['bank' => function($query){
                $query->select('id','type','name');
            }]);
        }]);
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
            Column::make('transaction_date'),
            Column::make('type'),
            Column::make('description'),
            Column::computed('transaction_method'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Transaction_' . date('YmdHis');
    }

    public function getFilters()
    {
        return null;
    }
}
