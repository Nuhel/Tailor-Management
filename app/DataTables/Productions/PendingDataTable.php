<?php
namespace App\DataTables\Productions;


use App\Models\Order;
use Illuminate\Http\Request;
use App\DataTables\DataTable;
use Yajra\DataTables\Html\Column;

class PendingDataTable extends DataTable
{

    protected $tableId = 'pending-table';

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

            ->addIndexColumn()
            ->rawColumns(['transaction']);
    }

    public function html(){
        $htmlBuilder = parent::html();
        return $htmlBuilder->minifiedAjax( route('productions.pending') );
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->paid()
        ->with('services')
        ->whereHas('services', function ($query){
            $query->where('status', 'pending');
        });
    }

    public function getColumns():array
    {
        return $this->addVerticalAlignmentToColumns( [
            Column::computed('index','SL')->width(20),
            Column::make('invoice_no'),
            Column::make('customer_name'),
            Column::computed('transaction')->addClass('due'),

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
