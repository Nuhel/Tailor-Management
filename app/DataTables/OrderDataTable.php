<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Constant\ServiceStatus;
use App\Exports\OrderExport;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class OrderDataTable extends DataTable
{

    protected $tableId = 'order-table';
    protected $exportClass = OrderExport::class;

    public function dataTable(Request $request,$query)
    {

        return datatables()

            ->eloquent($query)
            ->filter(function ($query) use ($request) {
                if($request->has('from') && strlen($request->from)){
                    try{
                        return $query->whereDate('order_date', '>=', Carbon::parse($request->from));
                    }catch(\Exception $e){
                        return $query;
                    }
                }
                if($request->has('to') && strlen($request->to)){
                    try{
                        return $query->whereDate('order_date', '<=', Carbon::parse($request->to));
                    }catch(\Exception $e){
                        return $query;
                    }
                }
            })
            ->filterColumn('customer_name', function($query, $keyword) {
                $query->whereHas('customer', function ($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->addColumn('customer_name', function(Order $order) {
                return $order->customer->name;
            })->addColumn('status', function(Order $order) {

                $return =  "Pending : ".($order->service_pending).
                "<br>Processing: ".($order->service_processing).
                "<br>Ready: ".($order->service_ready);

                return $return;
            })
            ->addColumn('transaction', function(Order $order) {
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
                    <a type="button" class="btn btn-outline-primary btn-sm " data-toggle="modal" data-target="#take-payment-modal" data-id="'.$order->id.'" data-due="'.($order->netpayable - $order->paid).'">
                        <i class="fas fa-hand-holding-usd"></i>
                    </a>

                    <a type="button" target="_blank" class="btn btn-outline-primary btn-sm" href="'.route('makeInvoice',['order'=>$order]).'">
                        <i class="fas fa-print"></i>
                    </a>';
                return view('components.actionbuttons.table_actions')->with('extraButton',trim($extraButton))->with('route','orders')->with('param','order')->with('value',$order)
                ->with('enableBottomMargin', true)->render();
            })

            ->addIndexColumn()
            ->rawColumns(['actions','status','transaction','print']);
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->withCount([
            'services as service_processing' => function($query){ $query->where('status', ServiceStatus::PROCESSING);}
        ])->withCount([
            'services as service_pending' => function($query){ $query->where('status', ServiceStatus::PENDING);}
        ])->withCount([
            'services as service_ready' => function($query){ $query->where('status', ServiceStatus::READY);}
        ])->whereIsSale(0)->paidRaw();
    }

    public function html(){
        return parent::html()
        //->parameters()
        ->initComplete('function(settings, json){
            var dtTable = $(this).dataTable().api();
            $(".from").on("keyup change",function() {
                dtTable.draw();
            });

            $(".to").on("keyup change",function() {
                dtTable.draw();
            });

        }')
        ->ajax([
            'data' => 'function(data){
                data.from = $(".from").val();
                data.to = $(".to").val();
            }'
        ]);
    }

    public function getColumns():array
    {
        return $this->addVerticalAlignmentToColumns( [
            Column::computed('index','SL')->width(20),
            Column::make('invoice_no'),
            Column::make('order_date'),
            Column::make('delivery_date'),
            Column::computed('customer_name'),
            Column::computed('status'),
            Column::computed('transaction')->addClass('due'),
            //Column::computed('print'),
            Column::computed('actions')->addClass('align-middle')
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
            '3'=>'Customer Name',

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
