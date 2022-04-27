<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Collection;

class TransactionDataTable extends DataTable
{
    protected $tableId = "transaction-table";




    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('transaction_method', function(Transaction $transaction) {
                return $transaction->sourceable == null? "Cash Payment":
                $transaction->sourceable->bank->name . "<br>Number: {$transaction->sourceable->number}".(
                    $transaction->sourceable->card? "<br>Card: ".$transaction->sourceable->card:""
                );
            })
            ->addColumn('transactionable_method', function(Transaction $transaction){
                $data = $transaction->transactionable;
                if($data == null){
                    return "---";
                }
                if($transaction->transactionable->name){
                    return $transaction->transactionable->name;
                }
                if($transaction->transactionable->invoice_no){
                    return $transaction->transactionable->invoice_no;
                }if($transaction->transactionable_type == "App\\Models\\OrderService"){
                    return "---";
                }
                return $transaction->toJson();
            })
            ->addIndexColumn()
            ->rawColumns(['actions','transaction_method']);
    }

    public function query(Transaction $model)
    {
        return $model->newQuery()->with(['sourceable' => function($query){
            $query->select('id','bank_id','number','card')->with(['bank' => function($query){
                $query->select('id','type','name');
            }]);
        }])
        ->with('transactionable');
    }

    public function render($view, $data = [], $mergeData = [])
    {
        $this->response(function($data){
            return ($this->makeResponse($data->toArray()));
        });
        return parent::render($view,$data,$mergeData);
    }

    public function makeResponse($data){
        $oldData = $data;
        $orderService  = collect($oldData['data'])->filter(function ($value, $key) {
            return $value['transactionable_type'] == 'App\Models\OrderService';
        });
        $orders = Order::select('id','invoice_no')->find($orderService->pluck('transactionable.order_id'));
        $service = Service::select('id','name')->find($orderService->pluck('transactionable.service_id'));

        $newData = $oldData['data'];
        foreach($newData as $key => $dt){
            if($dt['transactionable_type'] == 'App\Models\OrderService'){
                if($dt['transactionable'] != null){
                    $orderId = $dt['transactionable']['order_id'];
                    $serviceId = $dt['transactionable']['service_id'];
                    $oldData['data'][$key]['transactionable']['order'] = $orders->find($orderId)->toArray();
                    $oldData['data'][$key]['transactionable_method'] = "Invoice No: ".$orders->find($orderId)->toArray()['invoice_no']."<br>Service: ".$service->find($serviceId)->toArray()['name'];
                }else{
                    $oldData['data'][$key]['transactionable_method'] = "Service Deleted";
                }

            }

        }

        return $oldData;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            Column::computed('index','SL')->width(20),
            Column::make('amount'),
            Column::make('transaction_date'),
            Column::make('type'),
            Column::make('description'),
            Column::make('transactionable_method'),
            Column::computed('transaction_method'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Transaction_' . date('YmdHis');
    }

    public function getFilters()
    {
        return null;
    }
}
