<?php

namespace App\Http\Requests;


class SendToProductionRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'employee_id'=>'nullable|numeric|exists:employees,id',
        ];
    }
}
