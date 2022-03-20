<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TweetOnBehalfRequest extends FormRequest
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
            'user_id'       =>  'required',
            'content'       =>  'required|max:281',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errorResponse = [
            'message'       =>  'Validation error',
            'errors'        =>  $validator->errors()
        ];
        throw new HttpResponseException(response()->json($errorResponse, 422));
    }
}
