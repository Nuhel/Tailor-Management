<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class CustomerDataTable extends DataTable
{

    protected $tableId = 'customer-table';

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
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', "like", "%".$keyword."%");
            })->filterColumn('mobile', function($query, $keyword) {
                $query->where('mobile', "like", "%".$keyword."%");
            })->filterColumn('address', function($query, $keyword) {
                $query->where('address', "like", "%".$keyword."%");
            })
            ->addColumn('actions', function(Customer $customer) {
                return view('components.actionbuttons.table_actions')->with('route','customers')->with('param','customer')->with('value',$customer)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
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
            Column::make('mobile'),
            Column::make('address'),
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
        return 'Customer_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Name',
            '2'=>'Mobile',
            '3'=>'Address',
        ];
    }
}
