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
            })->addColumn('due', function(Order $order) {
                return ($order->netpayable - $order->paid);
            })
            ->addColumn('actions', function(Order $order) {
                $extraButton = "";
                if($order->paid < $order->netpayable)

                    $extraButton = '
                    <button type="button" class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#take-payment-modal" data-id="'.$order->id.'">
                        <i class="fa fa-edit" aria-hidden="true">
                        Take
                        </i>
                    </button>';
                return view('components.actionbuttons.table_actions')->with('extraButton',trim($extraButton))->with('route','orders')->with('param','order')->with('value',$order)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->paid();
    }

    public function getColumns()
    {
        return [
            Column::computed('index','SL')->width(20),
            Column::make('customer_name'),
            Column::computed('netpayable')->addClass('netpayable'),
            Column::computed('paid')->addClass('paid'),
            Column::computed('due')->addClass('due'),
            Column::computed('actions')
                  ->exportable(false)
                  ->printable(false)
                  ->width(320)
                  ->addClass('text-center')

        ];
    }

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
