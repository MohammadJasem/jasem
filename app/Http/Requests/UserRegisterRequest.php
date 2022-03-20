<?php

namespace App\Http\Requests;

use App\Rules\HatedChars;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            'name'      =>  'required|string|min:3|max:255',
            'email'     =>  'required|email|unique:users',
            'username'  =>  ['required','string', 'min:3', 'max:255', 'unique:users', new HatedChars('5')],
            'password'  =>  'required|min:8|max:255'
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
