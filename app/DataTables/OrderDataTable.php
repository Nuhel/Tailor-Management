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
            ->filterColumn('invoice_no', function($query, $keyword) {
                $query->where('invoice_no', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('customer_name', function($query, $keyword) {
                $query->whereHas('customer', function ($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->addColumn('customer_name', function(Order $order) {
                return $order->customer->name;
            })->addColumn('transaction', function(Order $order) {

                $return =  "Net Payable: ".($order->netpayable).
                "<br>Paid: ".($order->paid);

                if($order->netpayable - $order->paid)
                $return.="<br>Due: ".($order->netpayable - $order->paid);

                return $return;
            })
            ->addColumn('actions', function(Order $order) {
                $extraButton = "";
                if($order->paid < $order->netpayable)

                    $extraButton = '
                    <a type="button" class="btn btn-outline-primary btn-sm mr-2 mb-2" data-toggle="modal" data-target="#take-payment-modal" data-id="'.$order->id.'">
                        <i class="fa fa-edit" aria-hidden="true">
                        Take
                        </i>
                    </a>';
                return view('components.actionbuttons.table_actions')->with('extraButton',trim($extraButton))->with('route','orders')->with('param','order')->with('value',$order)
                ->with('enableBottomMargin', true)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions','transaction']);
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->paid();
    }

    public function getColumns():array
    {
        return $this->addVerticalAlignmentToColumns( [
            Column::computed('index','SL')->width(20),
            Column::make('invoice_no'),
            Column::make('customer_name'),
            Column::computed('transaction')->addClass('due'),
            Column::computed('actions')
                  ->exportable(false)
                  ->printable(false)
                  ->width(160)
                  ->addClass('text-center')

        ]);
    }

    protected function filename()
    {
        return 'Order_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Invoice',
            '2'=>'Customer Name',
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