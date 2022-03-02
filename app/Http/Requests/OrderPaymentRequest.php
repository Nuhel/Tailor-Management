<?php

namespace App\Http\Requests;

use App\Services\OrderService as ServiceOrderService;

class OrderPaymentRequest extends BaseRequest
{
    public function rules()
    {
        $order  = $this->route('order');
        $order  = ServiceOrderService::attachRelationalData($order, true)->find($order->id);
        $due    =  $order->netpayable - $order->paid;
        return [
            'amount' => 'required|numeric|min:1|max:'.$due,
            'date'   => 'required|date'
        ];
    }
}
