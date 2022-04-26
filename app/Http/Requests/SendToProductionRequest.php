<?php

namespace App\Http\Requests;


class SendToProductionRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {   //dd($this->toArray());
        return [
            'employee_id'=>'nullable|numeric|exists:employees,id',
            'deadline'  => ($this->employee_id == null?'nullable':'required').'|date'
        ];
    }
}
