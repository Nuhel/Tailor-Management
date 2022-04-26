<?php

namespace App\DataTables\Reports;


use Carbon\Carbon;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\DataTables\DataTable;
use Yajra\DataTables\Html\Column;

class PurchaseDataTable extends DataTable
{

    protected $tableId = 'purchase-report-table';

    public function dataTable(Request $request, $query)
    {

        return datatables()
            ->eloquent($query)
            ->filter(function ($query) use ($request) {
                if ($request->has('from') && strlen($request->from)) {
                    try {
                        $query->whereDate('purchase_date', '>=', Carbon::parse($request->from));
                    } catch (\Exception $e) {

                    }
                }
                if ($request->has('to') && strlen($request->to)) {
                    try {
                        $query->whereDate('purchase_date', '<=', Carbon::parse($request->to));
                    } catch (\Exception $e) {

                    }
                }

                if($request->has('status') && $request->status!= null){

                    if($request->status == 'paid'){
                        $query->withSum('payments as total_paid', 'amount')
                        ->havingRaw('total_paid >= purchases.netpayable');
                    }
                    else if($request->status == 'due'){
                        $query->withSum('payments as total_paid', 'amount')
                        ->havingRaw('total_paid < purchases.netpayable');
                    }

                }
            })
            ->filterColumn('invoice_no', function ($query, $keyword) {
                $query->where('invoice_no', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('supplier_name', function ($query, $keyword) {
                $query->whereHas('supplier', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('supplier_name', function (Purchase $purchase) {
                //dd($purchase);
                return $purchase->supplier->name;
            })->addColumn('transaction', function (Purchase $purchase) {
                $return =  "<div>Net Payable: " . ($purchase->netpayable) . "</div>" .
                    "<div>Paid: " . ($purchase->paid) . "</div>";
                if ($purchase->netpayable - $purchase->paid)
                    $return .= "<div><span>Due: " . ($purchase->netpayable - $purchase->paid) . '</span> </div>';
                return $return;
            })
            ->addIndexColumn()
            ->rawColumns(['transaction','print']);
    }

    public function html()
    {
        return parent::html()->initComplete('function(settings, json){
            var dtTable = $(this).dataTable().api();
                $("#' . $this->tableId . '-search .from").on("keyup change",function() {
                    dtTable.draw();
                });

                $("#' . $this->tableId . '-search .to").on("keyup change",function() {
                    dtTable.draw();
                });
                $("#' . $this->tableId . '-search .status").on("keyup change",function() {
                    dtTable.draw();
                });

        }')
            ->ajax([

                'data' => 'function(data){
                data.from = $("#' . $this->tableId . '-search .from").val();
                data.to = $("#' . $this->tableId . '-search .to").val();
                data.status = $("#' . $this->tableId . '-search .status").val();

            }'
            ]);
    }

    public function query(Purchase $model)
    {
        return $model->newQuery()->with('supplier')->withCount('products')
        ->paidRaw();
    }

    public function getColumns(): array
    {
        return $this->addVerticalAlignmentToColumns([
            Column::computed('index', 'SL')->width(20),
            Column::make('invoice_no')->width(100),
            Column::make('purchase_date'),
            Column::make('supplier_name'),
            Column::make('products_count'),
            Column::computed('transaction')->addClass('due'),
        ]);
    }

    protected function filename()
    {
        return 'Order-Report' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1' => 'Invoice',
        ];
    }

    public function overrideButtons()
    {
        return [
            'create' => null,
            'export' => null,
            'print' => null,
            'reset' => null,
            'reload' => null,
        ];
    }


    public function buildProductsTable($products){
        $table = "<div class=''><ul>
            <li class='d-flex justify-content-between'>
                <span><small>Qty</small></span>
                <span><small>CP</small></span>
                <span><small>SP</small></span>
                <span><small>P</small></span>
            </li>
        ";
        foreach ($products as $product) {
            $profit = ($product->price - $product->supplier_price) * $product->quantity;
            $table .= "<li class='d-flex justify-content-between'>

                        <span><small>{$product->quantity}</small></span>
                        <span><small>{$product->supplier_price}</small></span>
                        <span><small>{$product->price}</small></span>
                        <span><small>{$profit}</small></span>

                    </li>";
            $table .= "</ul></div>";
        }
    }
}
