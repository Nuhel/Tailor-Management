<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class OrderDataTable extends DataTable
{

    protected $tableId = 'order-table';

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
            ->filterColumn('customer_name', function($query, $keyword) {
                $query->whereHas('customer', function ($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->addColumn('customer_name', function(Order $order) {
                return $order->customer->name;
            })
            ->addColumn('actions', function(Order $order) {
                return view('components.actionbuttons.table_actions')->with('route','orders')->with('param','order')->with('value',$order)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->newQuery()->with('customer');
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
            Column::make('customer_name'),
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
        return 'Order_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Customer Name',
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
