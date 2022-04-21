<?php

namespace App\Http\Requests;

use App\Services\OrderService as ServiceOrderService;

class EmployeePaymentRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'craftsman_id' => 'required|numeric|exists:employees,id',
            'amount' => 'required|numeric|min:1',
            'date'   => 'required|date',
            'description' => "nullable|string"
        ];
    }
}
