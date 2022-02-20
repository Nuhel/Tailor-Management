<?php

namespace App\DataTables;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
class BankAccountDataTable extends DataTable
{
    protected $tableId = 'bankaccountdatatable';
    public function dataTable(Request $request,$query)
    {
        return datatables()
            ->eloquent($query)
            ->filter(function ($query) use ($request) {
                //dd($request->toArray());
                //$query;
            },true)

            ->filterColumn('card', function($query, $keyword) {
                $query->where('card', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('number', function($query, $keyword) {
                $query->where('number', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('bank', function($query, $keyword) {
                $query->whereHas('bank', function ($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->addColumn('bank', function (BankAccount $bankAccount) {
                return $bankAccount->bank->name;
            })->addColumn('actions', function(BankAccount $bankAccount) {
                return view('components.actionbuttons.table_actions')->with('route','bank_accounts')->with('param','bank_account')->with('value',$bankAccount)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BankAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BankAccount $model)
    {
        return $model->newQuery()->with('bank');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */


    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            Column::computed('index','SL')->width(20),
            Column::make('bank'),
            Column::make('number'),
            Column::make('card'),
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
        return 'BankAccount_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Bnak',
            '2'=>'Number',
            '3'=>'Card',
        ];
    }
}
