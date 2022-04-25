<?php

namespace App\DataTables;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
class PurchaseDataTable extends DataTable
{
    protected $tableId = 'purchase-table';

    public function dataTable(Request $request,$query){

        return datatables()
            ->eloquent($query)
            ->filterColumn('invoice_no', function($query, $keyword) {
                $query->where('invoice_no', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('supplier_name', function($query, $keyword) {
                $query->whereHas('supplier', function ($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->addColumn('supplier_name', function(Purchase $purchase) {

                return $purchase->supplier->name;
            })
            ->addColumn('transaction', function(Purchase $purchase) {
                $return =  "Net Payable: ".($purchase->netpayable).
                "<br>Paid: ".($purchase->paid);
                if($purchase->netpayable - $purchase->paid)
                $return.="<br>Due: ".($purchase->netpayable - $purchase->paid);
                return $return;
            })
            ->addColumn('actions', function(Purchase $purchase) {
                $extraButton = "";
                if($purchase->paid < $purchase->netpayable)
                    $extraButton = '
                    <a type="button" class="btn btn-outline-primary btn-sm " data-toggle="modal" data-target="#give-payment-modal" data-id="'.$purchase->id.'" data-due="'.($purchase->netpayable - $purchase->paid).'">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </a>';
                return view('components.actionbuttons.table_actions')->with('route','purchases')->with('param','purchase')->with('value',$purchase)
                ->with('extraButton',trim($extraButton))
                ->with('enableBottomMargin', true)->render();
            })

            ->addIndexColumn()
            ->rawColumns(['actions','transaction','print']);
    }

    public function query(Purchase $model)
    {
        return $model->newQuery()->with('supplier')->paid();
    }

    public function getColumns():array
    {
        return $this->addVerticalAlignmentToColumns( [
            Column::computed('index','SL')->width(20),
            Column::make('invoice_no'),
            Column::make('supplier_name'),
            Column::computed('transaction')->addClass('due'),
            //Column::computed('print'),
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
