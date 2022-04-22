<?php

namespace App\Http\Requests;

use App\Services\OrderService as ServiceOrderService;

class EmployeePaymentRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'order_service_id' => 'required|numeric|exists:order_services,id',
            'amount' => 'required|numeric|min:1',
            'date'   => 'required|date',
            'description' => "nullable|string"
        ];
    }
}
