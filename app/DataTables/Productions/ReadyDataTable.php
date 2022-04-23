<?php
namespace App\DataTables\Productions;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\DataTables\DataTable;
use App\Constant\ServiceStatus;
use Yajra\DataTables\Html\Column;

class ReadyDataTable extends DataTable
{

    protected $tableId = 'ready-table';

    public function dataTable(Request $request,$query){

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
            })->addColumn('services', function(Order $order) {
                $table = "<table class='table table-sm m-0'>
                            <thead>
                                <tr>
                                    <th>Name - Qty</th>
                                    <th class='text-right'>CraftsMan</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                foreach($order->services as $service){
                    $hasEmployee = $service->employee != null?true:false;

                    $button = "Prepared By ".$service->employee->name;

                    $table .= "<tr>
                                    <td><small>{$service->service->name} - {$service->quantity}</small></td>
                                    <td class='text-right'><small>".
                                        ($button)."</small></td>
                                </tr>";
                }
                $table .= " </tbody>
                        </table>";
                return $table;
            })->addColumn('transaction', function(Order $order) {
                $return =  "<div>Net Payable: ".($order->netpayable)."</div>".
                "<div>Paid: ".($order->paid)."</div>";
                if($order->netpayable - $order->paid)
                $return.="<div><span>Due: ".($order->netpayable - $order->paid). '</span></div>';
                return $return;
            })
            ->addColumn('print', function(Order $order) {

                $extraButton = "";
                if($order->paid < $order->netpayable)
                    $extraButton = '
                    <a type="button" class="btn btn-outline-primary btn-sm mr-2 mb-2" data-toggle="modal" data-target="#take-payment-modal" data-id="'.$order->id.'" data-due="'.($order->netpayable - $order->paid).'">
                        <i class="fa fa-edit" aria-hidden="true">
                        Take
                        </i>
                    </a>';

                return '
                    <a type="button" target="_blank" class="btn btn-outline-primary btn-sm mr-2 mb-2" href="'.route('makeInvoice',['order'=>$order]).'">
                        <i class="fa fa-edit" aria-hidden="true">
                        Print Invoice
                        </i>
                    </a>'.$extraButton;
            })

            ->addIndexColumn()
            ->rawColumns(['transaction','services','print']);
    }

    public function html(){
        return parent::html()->initComplete('function(settings, json){
            var dtTable = $(this).dataTable().api();
            $("#'.$this->tableId.'-search .from").on("keyup change",function() {
                dtTable.draw();
            });

            $("#'.$this->tableId.'-search .to").on("keyup change",function() {
                dtTable.draw();
            });

        }')
        ->ajax([
            'url' => route('productions.ready'),
            'data' => 'function(data){
                data.from = $("#'.$this->tableId.'-search .from").val();
                data.to = $("#'.$this->tableId.'-search .to").val();
            }'
        ]);
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->paid()
        ->with(['services' => function($query){
            return $query->with('service')->with('employee')->with('serviceMeasurements.measurement')->with('serviceDesigns')->where('status', ServiceStatus::READY);
        }])
        ->whereHas('services', function ($query){
            $query->where('status', ServiceStatus::READY);
        });
    }

    public function getColumns():array
    {
        return $this->addVerticalAlignmentToColumns( [
            Column::computed('index','SL')->width(20),
            Column::make('invoice_no')->width(100),
            Column::make('order_date'),
            Column::make('delivery_date'),
            Column::make('customer_name')->width(300),
            Column::computed('services'),
            Column::computed('transaction')->addClass('due'),
            Column::computed('print'),

        ]);
    }

    protected function filename()
    {
        return 'Pending-Services' . date('YmdHis');
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
