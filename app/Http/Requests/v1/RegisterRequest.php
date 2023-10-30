<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ResponseHelper;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => [
                'required',
                'string',
                'min:8',                // must be at least 8 characters in length
                'regex:/[a-z]/',        // must contain at least one lowercase letter
                'regex:/[A-Z]/',        // must contain at least one uppercase letter
                'regex:/[0-9]/',        // must contain at least one digit
                'regex:/[@$!%*#?&]/',   // must contain a special character
            ]
        ];
    }    

    # Custom Messages
    public function messages() {
        return [
            'password.regex' => trans('api.STRONG_PASSWORD'),
        ];
    }

    # Custom Error Response
    protected function failedValidation(Validator $validator) {        
        throw new HttpResponseException(ResponseHelper::fail([], ResponseHelper::error_parse($validator->errors()), config('code.VALIDATION_ERROR_CODE')));
    }
}
