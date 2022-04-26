<?php
namespace App\DataTables\Productions;


use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\DataTables\DataTable;
use App\Constant\ServiceStatus;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class ProcessingDataTable extends DataTable
{

    protected $tableId = 'processing-table';


    public function getButtons(){

        return [
            Button::make('pageLength')->addClass($this->buttonClass.' rounded'),
            Button::make('spacer')->raw('<p></p>')->className('btn-link bg-transparent spacer')->attr(['disabled'=>'disabled']),
            $this->getButton('export'),
            $this->getButton('print'),
            $this->getButton('reset'),
            $this->getButton('reload'),
        ];
    }

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
                                    <th class='text-right'>Ready</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                foreach($order->services as $service){
                    $hasEmployee = $service->employee != null?true:false;
                    $button = "<a href='' class='btn-clipboard' data-toggle='modal' data-target='#asign-craftsman-modal' data-id='".$service->id."'> "
                        .($hasEmployee? $service->employee->name :"Send To Production")
                        .($hasEmployee?"<i class='fa fa-edit ml-2' aria-hidden='true'></i>":"").

                        "</a>".($service->deadline?"<br>DL: ".Carbon::parse($service->deadline)->format('Y-m-d'):"");

                        $table .= "<tr>
                            <td><small>{$service->service->name} - {$service->quantity}</small></td>
                            <td class='text-right'>
                                    <small>".($button)."</small>

                            </td>

                            <td class='text-right'>
                                <div class='icheck-success icheck-inline mr-3'>
                                    <input class='ready-checkbox' type='checkbox' id='service-ready".$service->id."' data-id='".$service->id."'>
                                    <label for='service-ready".$service->id."'></label>
                                </div>
                            </td>
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
            ->addColumn('action', function(Order $order) {

                $takePaymentButton = "";
                if($order->paid < $order->netpayable)
                    $takePaymentButton = '
                    <a type="button" class="btn btn-outline-primary btn-sm mr-2 mb-2" data-toggle="modal" data-target="#take-payment-modal" data-id="'.$order->id.'" data-due="'.($order->netpayable - $order->paid).'">
                        <i class="fas fa-hand-holding-usd"></i>
                    </a>';

                return '
                    <a type="button" target="_blank" class="btn btn-outline-primary btn-sm mr-2 mb-2" href="'.route('makeInvoice',['order'=>$order]).'">
                        <i class="fas fa-print"></i>
                    </a>'.$takePaymentButton;
            })

            ->addIndexColumn()
            ->rawColumns(['transaction','services','action']);
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
            'url' => route('productions.processing'),
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
            return $query->with('service')->with('employee')->with('serviceMeasurements.measurement')->with('serviceDesigns')->where('status', ServiceStatus::PROCESSING);
        }])
        ->whereHas('services', function ($query){
            $query->where('status', ServiceStatus::PROCESSING);
        });
    }

    public function getColumns():array
    {
        return $this->addVerticalAlignmentToColumns( [
            Column::computed('index','SL')->width(20),
            Column::make('invoice_no')->width(100),
            Column::make('order_date'),
            Column::make('delivery_date'),
            Column::make('customer_name')->width(100),
            Column::computed('services'),
            Column::computed('transaction')->addClass('due')->width(130),
            Column::computed('action')->width(90),
        ]);
    }

    protected function filename()
    {
        return 'Processing-Services_' . date('YmdHis');
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
