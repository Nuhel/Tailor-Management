<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Services\OrderService as ServiceOrderService;

class EmployeePaymentRequest extends BaseRequest
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

        return [
            'order_service_id' => 'required|numeric|exists:order_services,id',
            'amount' => 'required|numeric|min:1',
            'date'   => 'required|date',
            'description' => "nullable|string",
            'account_id'                        =>  $accountIdRule,
        ];
    }
}
