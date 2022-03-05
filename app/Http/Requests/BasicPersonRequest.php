<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BasicPersonRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ];
    }
}
