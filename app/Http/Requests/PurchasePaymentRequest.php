<?php

namespace App\Http\Requests;

use App\Services\PurchaseService;
use Illuminate\Validation\Rule;
class PurchasePaymentRequest extends BaseRequest
{
    public function rules()
    {

        $accountIdRule = [
            Rule::requiredIf(function(){
                return $this->bank_type!="Cash Payment";
            })
        ];

        if($this->bank_type!="Cash Payment"){
            $accountIdRule[] = 'exists:bank_accounts,id';
        }
        $purchase  = $this->route('purchase');
        $purchase  = PurchaseService::attachRelationalData($purchase, true)->find($purchase->id);
        $due    =  $purchase->netpayable - $purchase->paid;

        return [
            'amount' => 'required|numeric|min:1|max:'.$due,
            'date'   => 'required|date',
            'account_id'                        =>  $accountIdRule,
        ];
    }
}
