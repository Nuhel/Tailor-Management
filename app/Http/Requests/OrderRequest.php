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
            'customer_id'                       =>  'required|numeric|exists:customers,id',
            'master_id'                         =>  'required|numeric|exists:masters,id',
            'services'                          =>  'required|array',
            'services.*.service_id'             =>  'required|numeric',
            'services.*.quantity'               =>  'required|numeric',
            'services.*.price'                  =>  'required|numeric',
            'services.*.measurements'           =>  'required|array',
            'services.*.measurements.*.size'    =>  'required|string|max:15',
            'services.*.measurements.*.id'      =>  'required|numeric|exists:service_measurements,id',
            'services.*.designs'                =>  'required|array',
            'services.*.designs.*.id'           =>  'required|numeric|exists:service_design_styles,id',
            'products'                          =>  'nullable|array',
        ];
    }

    public function messages()
{
    return [
        'services.*.service_id.required'            => "Servie is required",
        'services.*.quantity.required'              => "Quantity is required",
        'services.*.price.required'                 => "Price is required",
        'services.*.measurements.*.size.required'   => "Size is required",
        'services.*.designs.*.id.required'          => "Design is required",
    ];
}
}
