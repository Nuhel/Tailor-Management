<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Services\OrderService as ServiceOrderService;

class OrderPaymentRequest extends BaseRequest
{
    public function rules()
    {
        $order  = $this->route('order');
        $order  = ServiceOrderService::attachRelationalData($order, true)->find($order->id);
        $due    =  $order->netpayable - $order->paid;

        $accountIdRule = '';
        if($this->bank_type!="Cash Payment"){
            $accountIdRule = 'required|exists:bank_accounts,id';
        }

        return [
            'amount' => 'required|numeric|min:1|max:'.$due,
            'date'   => 'required|date',
            'account_id'                        =>  $accountIdRule,
        ];
    }
}
