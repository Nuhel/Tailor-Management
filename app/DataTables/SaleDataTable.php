<?php

namespace App\DataTables;
use App\Models\Order;
use App\Constant\ServiceStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
class SaleDataTable extends DataTable
{
    protected $tableId = 'sale-table';

    public function dataTable(Request $request,$query){

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
            ->addColumn('customer_name', function(Order $sale) {
                return $sale->customer->name;
            })
            ->addColumn('transaction', function(Order $sale) {
                $return =  "Net Payable: ".($sale->netpayable).
                "<br>Paid: ".($sale->paid);
                if($sale->netpayable - $sale->paid)
                $return.="<br>Due: ".($sale->netpayable - $sale->paid);
                return $return;
            })
            ->addColumn('actions', function(Order $sale) {
                $extraButton = "";
                if($sale->paid < $sale->netpayable)
                    $extraButton = '
                    <a type="button" class="btn btn-outline-primary btn-sm " data-toggle="modal" data-target="#take-payment-modal" data-id="'.$sale->id.'" data-due="'.($sale->netpayable - $sale->paid).'">
                        <i class="fas fa-hand-holding-usd"></i>
                    </a>

                    <a type="button" target="_blank" class="btn btn-outline-primary btn-sm" href="'.route('makeInvoice',['order'=>$sale]).'">
                        <i class="fas fa-print"></i>
                    </a>';
                return view('components.actionbuttons.table_actions')->with('extraButton',trim($extraButton))->with('route','sales')->with('param','sale')->with('value',$sale)
                ->with('enableBottomMargin', true)->render();
            })

            ->addIndexColumn()
            ->rawColumns(['actions','transaction','print']);
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->withCount([
            'services as service_processing' => function($query){ $query->where('status', ServiceStatus::PROCESSING);}
        ])->withCount([
            'services as service_pending' => function($query){ $query->where('status', ServiceStatus::PENDING);}
        ])->withCount([
            'services as service_ready' => function($query){ $query->where('status', ServiceStatus::READY);}
        ])->whereIsSale(1)->paidRaw();
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
        return 'Sale_' . date('YmdHis');
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
