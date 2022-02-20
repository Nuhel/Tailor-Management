<?php

namespace App\DataTables;
use App\Models\Bank;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class BanksDataTable extends DataTable
{
    protected $tableId = "banksdatatable";
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('actions', function(Bank $bank) {
                return view('components.actionbuttons.table_actions')->with('route','banks')->with('param','bank')->with('value',$bank)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    public function query(Bank $model)
    {
        return $model->newQuery();
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
            Column::make('name'),
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
        return 'Banks_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Bnak',
        ];
    }
}
