<?php

namespace App\DataTables;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BankAccountDataTable extends DataTable
{

    public function dataTable(Request $request,$query)
    {

        return datatables()
            ->eloquent($query)
            ->filter(function ($query) use ($request) {
                //dd($request->toArray());
                 $query;
            },true)
            ->filterColumn('card', function($query, $keyword) {
                $query->where('card', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('number', function($query, $keyword) {
                $query->where('number', 'like', '%'.$keyword.'%');
            })
            ->addColumn('action', 'bankaccountdatatable.action')
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
    public function html()
    {
        return $this->builder()
                    ->setTableId('bankaccountdatatable')
                    ->addTableClass('table-sm table-striped')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('index','SL')->width(20),
            Column::make('bank'),
            Column::make('number'),
            Column::make('card'),
            Column::computed('actions')->addClass('text-right'),
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
}
