<?php

namespace App\Http\Requests;

class StockManageRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products'          =>  'required|array',
            'products.*.id'     =>  ['numeric','exists:products,id'],
            'products.*.stock'  =>  ['numeric','min:1']
        ];
    }

    public function messages()
    {
        return [
            'products.*.stock.numeric' => "Stock Must Be A Number"
        ];
    }
}
