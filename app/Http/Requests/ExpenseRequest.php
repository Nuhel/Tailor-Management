<?php

namespace App\Http\Requests;
class ExpenseRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $accountIdRule = '';
        if($this->bank_type!="Cash Payment"){
            $accountIdRule = 'required|exists:bank_accounts,id';
        }

        return [
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:1',
            'date'   => 'required|date',
            'account_id'                        =>  $accountIdRule,
        ];
    }
}
