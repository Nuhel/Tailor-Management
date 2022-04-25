<?php

namespace App\Http\Requests;

use App\Services\PurchaseService;

class PurchasePaymentRequest extends BaseRequest
{
    public function rules()
    {
        $purchase  = $this->route('purchase');
        $purchase  = PurchaseService::attachRelationalData($purchase, true)->find($purchase->id);
        $due    =  $purchase->netpayable - $purchase->paid;
        return [
            'amount' => 'required|numeric|min:1|max:'.$due,
            'date'   => 'required|date'
        ];
    }
}
