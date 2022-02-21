<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
class OrderRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'services.*.designs.*.id.numeric' => "Design Must Be Selected"
        ];
    }

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

        $aditionalRule = [];
        if(! $this->passProductCheck){
            $aditionalRule = [
                'products'                          =>  'nullable|array',
                'products.*.id'                     =>  'required|numeric|exists:products,id',
                'products.*.quantity'               =>  'required|numeric|max:99999|min:1',
                'products.*.price'                  =>  'required|numeric|max:99999|min:1',
            ];
        }

        $basicRule =  [
            'customer_id'                       =>  'required|numeric|exists:customers,id',
            'master_id'                         =>  'required|numeric|exists:masters,id',

            'services'                          =>  'required|array',
            'services.*.service_id'             =>  'required|numeric|exists:services,id',
            'services.*.quantity'               =>  'required|numeric|min:1',
            'services.*.price'                  =>  'required|numeric',
            'services.*.employee_id'            =>  'nullable|numeric||exists:employees,id',

            'services.*.measurements'           =>  'required|array',
            'services.*.measurements.*.size'    =>  'required|string|max:15',
            'services.*.measurements.*.id'      =>  'required|numeric|exists:service_measurements,id',

            'services.*.designs'                =>  'required|array',
            'services.*.designs.*.id'           =>  'required|numeric|exists:service_designs,id',
            'services.*.designs.*.style_id'     =>  'required|numeric|exists:service_design_styles,id',

            'account_id'                        =>  $accountIdRule,
            'total'                             =>  'required|numeric|min:0',
            'discount'                          =>  'nullable|numeric|min:0',
            'netpayable'                        =>  'required|numeric|gte:paid|gte:due',
            'paid'                              =>  'required|numeric|min:0',
            'due'                               =>  'required|numeric|min:0',
            'delivery_date'                     =>  'required|date',
            'trial_date'                        =>  'required|date',
            'order_date'                        =>  'required|date',
        ];

        return array_merge($basicRule,$aditionalRule);
    }

    public function attributes()
    {
        return [
            'services.*.service_id'            => "Servie",
            'services.*.quantity'              => "Quantity",
            'services.*.price'                 => "Price",
            'services.*.employee_id'           => "Craftsman",
            'services.*.measurements.*.size'   => "Size",
            'services.*.designs.*.id'          => "Design ",
            'products.*.id'                    => "Product",
            'products.*.quantity'              => "Quantity",
            'account_id'                       => "Account",
        ];
    }
}
