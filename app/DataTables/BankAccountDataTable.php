<?php

namespace App\DataTables;

use App\Models\BankAccount;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BankAccountDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
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
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('bankaccountdatatable-table')
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
            Column::computed('DT_RowIndex','SL')->width(20),
            Column::make('bank'),
            Column::make('number'),
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
