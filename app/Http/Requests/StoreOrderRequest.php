<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id.*' => ['required', 'numeric', 'min:1', 'max:2147483647'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required' ,'email'],
            'phone' => ['required', 'numeric', 'digits:9'],
            'city' => ['required', 'string', 'min:2' , 'max:80'],
            'postal_code' => ['required', 'digits:5'],
            'street_name' => ['required', 'string','max:80'],
            'street_number' => ['required', 'numeric', 'min:0'],
            'flat_number' => ['nullable', 'numeric', 'min:0'],
            'company_name' => ['nullable', 'string'],
            'NIP' => ['nullable', 'numeric'],
            'extra_info' => ['nullable', 'string']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}