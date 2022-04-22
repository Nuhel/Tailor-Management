<?php

namespace App\Http\Requests;
use App\Rules\EnsureStock;
use Illuminate\Validation\Rule;
use App\Services\SaleService;

class SaleRequest extends BaseRequest
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

        $order  = $this->route('order');
        if($order != null){
            $order  = SaleService::attachRelationalData($order, true)->find($order->id);
        }


        $accountIdRule = [
            Rule::requiredIf(function(){
                return $this->bank_type!="Cash Payment";
            })
        ];

        if($this->bank_type!="Cash Payment"){
            $accountIdRule[] = 'exists:bank_accounts,id';
        }

        $aditionalRule = [
            'products'                          =>  'nullable|array',
            'products.*.id'                     =>  [Rule::requiredIf(function(){
                return (is_array($this->products) && count($this->products) && $this->products[0]!= null);
            }),'numeric','exists:products,id'],
            'products.*.quantity'               =>  [Rule::requiredIf(function(){
                return (is_array($this->products) && count($this->products) && $this->products[0]!= null);
            }),'numeric','max:99999','min:1', new EnsureStock($this->products,$this->route(),$order) ],
            'products.*.price'                  =>  [Rule::requiredIf(function(){
                return (is_array($this->products) && count($this->products) && $this->products[0]!= null);
            }),'numeric','max:99999','min:1'],
        ];

        $basicRule =  [
            'customer_id'                       =>  'required|numeric|exists:customers,id',
            'account_id'                        =>  $accountIdRule,
            'total'                             =>  'required|numeric|min:0',
            'discount'                          =>  'nullable|numeric|min:0',
            'netpayable'                        =>  'required|numeric|gte:paid|gte:due',
            'paid'                              =>  'required|numeric|min:0',
            'due'                               =>  'required|numeric|min:0',
            'order_date'                        =>  'required|date',
        ];

        return array_merge($basicRule,$aditionalRule);
    }

    public function attributes()
    {
        return [
            'products.*.id'                    => "Product",
            'products.*.quantity'              => "Quantity",
            'account_id'                       => "Account",
        ];
    }
}
