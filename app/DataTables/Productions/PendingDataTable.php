<?php
namespace App\DataTables\Productions;


use App\Models\Order;
use App\Constant\ServiceStatus;
use App\DataTables\DataTable;
use Yajra\DataTables\Html\Column;

class PendingDataTable extends DataTable
{

    protected $tableId = 'pending-table';

    public function dataTable($query){

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
            })->addColumn('services', function(Order $order) {
                $table = "<table class='table table-sm m-0'>
                            <thead>
                                <tr>
                                    <th> Name</th>
                                    <th class='text-right'>CraftsMan</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                foreach($order->services as $service){
                    $hasEmployee = $service->employee != null?true:false;
                    $button = "<a href='' class='btn-clipboard' data-toggle='modal' data-target='#asign-craftsman-modal' data-id='".$service->id."'> "
                        .($hasEmployee? $service->employee->name :"Send To Production")
                        .($hasEmployee?"<i class='fa fa-edit ml-2' aria-hidden='true'></i>":"").
                        "</a>";

                    $table .= "<tr>
                                    <td><small>".$service->service->name."</small></td>
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
                $return.="<div><span>Due: ".($order->netpayable - $order->paid). '</span> </div>';
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
        $htmlBuilder = parent::html();
        return $htmlBuilder->minifiedAjax( route('productions.pending') );
    }

    public function query(Order $model)
    {
        return $model->newQuery()->with('customer')->paid()
        ->with(['services' => function($query){
            return $query->with('service')->with('employee')->with('serviceMeasurements.measurement')->with('serviceDesigns')->where('status', ServiceStatus::PENDING);
        }])
        ->whereHas('services', function ($query){
            $query->where('status', ServiceStatus::PENDING);
        });
    }

    public function getColumns():array
    {
        return $this->addVerticalAlignmentToColumns( [
            Column::computed('index','SL')->width(20),
            Column::make('invoice_no'),
            Column::make('customer_name'),
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
