<?php

namespace App\Http\Requests\Subscriber;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSubscriberRequest extends FormRequest
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
            'email' => 'required|string|email'
        ];
    }

    /**
     * Throw error when auth is failed.
     */
    protected function failedAuthorization() {

        throw new HttpResponseException(response()->custom(403, "Unauthorized!", null));
    }

    /**
     * Throw error when validation is failed.
     *
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->custom(422, $validator->errors(), null));
    }
}
