<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
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
            'services.*.service_id'             =>  'required|numeric|exists:services,id',
            'services.*.quantity'               =>  'required|numeric|min:1',
            'services.*.price'                  =>  'required|numeric',

            'services.*.measurements'           =>  'required|array',
            'services.*.measurements.*.size'    =>  'required|string|max:15',
            'services.*.measurements.*.id'      =>  'required|numeric|exists:service_measurements,id',

            'services.*.designs'                =>  'required|array',
            'services.*.designs.*.id'           =>  'required|numeric|exists:service_design_styles,id',

            'products'                          =>  'nullable|array',
            'products.*.id'                     =>  'required|numeric|exists:products,id',
            'products.*.quantity'               =>  'required|numeric|max:99999|min:1',
            'products.*.price'                  =>  'required|numeric|max:99999|min:1',
            'account_id'                        =>  [Rule::requiredIf(function(){
                return $this->bank_type!="Cash Payment";
            }),'exists:bank_accounts,id']
        ];
    }

    public function attributes()
    {
        return [
            'services.*.service_id'            => "Servie",
            'services.*.quantity'              => "Quantity",
            'services.*.price'                 => "Price",
            'services.*.measurements.*.size'   => "Size",
            'services.*.designs.*.id'          => "Design ",
            'products.*.id'                    => "Product",
            'products.*.quantity'              => "Quantity",
            'account_id'                       => "Account",
        ];
    }
}
