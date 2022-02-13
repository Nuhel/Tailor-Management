<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
class BaseRequest extends FormRequest
{


    protected function failedValidation(Validator $validator)
    {

        if($this->wantsJson())
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        else
            throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}
