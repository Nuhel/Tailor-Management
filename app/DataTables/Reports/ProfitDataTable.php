<?php

namespace App\DataTables\Reports;


use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\DataTables\DataTable;
use App\Constant\ServiceStatus;
use Yajra\DataTables\Html\Column;

class ProfitDataTable extends DataTable
{

    protected $tableId = 'profit-table';

    public function dataTable(Request $request, $query)
    {

        return datatables()
            ->eloquent($query)
            ->filter(function ($query) use ($request) {
                if ($request->has('from') && strlen($request->from)) {
                    try {
                        return $query->whereDate('order_date', '>=', Carbon::parse($request->from));
                    } catch (\Exception $e) {
                        return $query;
                    }
                }
                if ($request->has('to') && strlen($request->to)) {
                    try {
                        return $query->whereDate('order_date', '<=', Carbon::parse($request->to));
                    } catch (\Exception $e) {
                        return $query;
                    }
                }
            })
            ->filterColumn('invoice_no', function ($query, $keyword) {
                $query->where('invoice_no', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('customer_name', function ($query, $keyword) {
                $query->whereHas('customer', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('customer_name', function (Order $order) {
                return $order->customer->name;
            })->addColumn('services', function (Order $order) {
                $table = "<div class=''><ul>
                                <li class='d-flex justify-content-between'>

                                    <span><small>Qty</small></span>
                                    <span><small>CP</small></span>
                                    <span><small>SP</small></span>
                                    <span><small>P</small></span>
                                </li>
                        ";

                $serviceTotalProfit = 0;
                $productTotalProfit = 0;

                foreach ($order->services as $service) {
                    $profit = ($service->price - $service->crafting_price) * $service->quantity;
                    $serviceTotalProfit += $profit;
                }

                foreach ($order->products as $product) {
                    $profit = ($product->price - $product->supplier_price) * $product->quantity;
                    $productTotalProfit += $profit;
                    $table .= "<li class='d-flex justify-content-between'>

                                <span><small>{$product->quantity}</small></span>
                                <span><small>{$product->supplier_price}</small></span>
                                <span><small>{$product->price}</small></span>
                                <span><small>{$profit}</small></span>

                            </li>";
                }
                $table .= "<li class='d-flex justify-content-between'>
                                <span><small>Qty</small></span>
                                <span><small>CP</small></span>
                                <span><small>SP</small></span>
                                <span><small>{$productTotalProfit}</small></span>
                            </li>";
                $table .= "</ul></div>";
                return $serviceTotalProfit + $productTotalProfit;
            })->addColumn('transaction', function (Order $order) {
                $return =  "<div>Net Payable: " . ($order->netpayable) . "</div>" .
                    "<div>Paid: " . ($order->paid) . "</div>";
                if ($order->netpayable - $order->paid)
                    $return .= "<div><span>Due: " . ($order->netpayable - $order->paid) . '</span> </div>';
                return $return;
            })


            ->addIndexColumn()
            ->rawColumns(['transaction', 'services', 'print']);
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

        }')
            ->ajax([

                'data' => 'function(data){
                data.from = $("#' . $this->tableId . '-search .from").val();
                data.to = $("#' . $this->tableId . '-search .to").val();
            }'
            ]);
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->paid()
            ->with(['services' => function ($query) {
                return $query->with('service');
            }])
            ->with('products');
    }

    public function getColumns(): array
    {
        return $this->addVerticalAlignmentToColumns([
            Column::computed('index', 'SL')->width(20),
            Column::make('invoice_no')->width(100),
            Column::make('order_date'),
            Column::computed('services'),
            Column::computed('transaction')->addClass('due'),

        ]);
    }

    protected function filename()
    {
        return 'Pending-Services' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1' => 'Invoice',
            '2' => 'Customer Name',
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
}
