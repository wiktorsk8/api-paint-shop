<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['nullable' ,'email'],
            'phone' => ['nullable', 'numeric', 'digits:9'],
            'city' => ['nullable', 'string', 'min:2' , 'max:80'],
            'postal_code' => ['nullable', 'digits:5'],
            'street_name' => ['nullable', 'string','max:80'],
            'street_number' => ['nullable', 'numeric', 'min:0'],
            'flat_number' => ['nullable', 'numeric', 'min:0'],
            'company_name' => ['nullable', 'string'],
            'NIP' => ['nullable', 'numeric'],
            'extra_info' => ['nullable', 'string']
        ];
    }
}
