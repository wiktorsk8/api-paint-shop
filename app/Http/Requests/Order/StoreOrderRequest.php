<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'numeric', 'min:1', 'max:2147483647'],
            'customer_id' => ['required', 'numeric', 'min:1', 'max:2147483647'],
            'city' => ['required', 'string', 'min:2' , 'max:80'],
            'postal_code' => ['required', 'digits:5'],
            'street_name' => ['required', 'string','max:80'],
            'street_number' => ['required', 'numeric', 'min:0'],
            'flat_number' => ['nullable', 'numeric', 'min:0']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'customer_id' => Auth::id(),
        ]);
    }
}
