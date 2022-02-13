<?php

namespace App\Http\Requests;

class OrderRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id'           =>  'required|numeric|exists:customers,id',
            'master_id'             =>  'required|numeric|exists:masters,id',
            'services'              =>  'required|array',
            'services.*.service_id' =>  'required|numeric',
            'services.*.quantity'   =>  'required|numeric',
            'services.*.price'      =>  'required|numeric',
            'products'              =>  'required:array',
        ];
    }

    public function messages()
{
    return [
        'title.required'                    => 'A title is required',
        'body.required'                     => 'A message is required',
        'services.*.service_id.required'    => "Servie is required",
        'services.*.quantity.required'      => "Quantity is required",
        'services.*.price.required'         => "Price is required",
    ];
}
}
