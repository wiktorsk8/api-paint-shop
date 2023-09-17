<?php

namespace App\Http\Requests\Order;

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
            'productId' => 'required|array',
            'productId.*' => 'required|numeric',
            'paymentIntentId' => 'required',
            'save' => 'required|boolean',
            'userData.credentials.firstName' => 'required',
            'userData.credentials.lastName' => 'required',
            'userData.credentials.email' => 'required|email',
            'userData.credentials.phone' => 'required',
            'userData.userId' => 'nullable',
            'userData.paymentMethod' => 'required',
            'userData.deliveryMethod' => 'required',
            'userData.address.city' => 'required',
            'userData.address.postalCode' => 'required',
            'userData.address.street' => 'required',
            'userData.address.buildingNumber' => 'required',
            'userData.address.countryCode' => 'required',
            'userData.address.extraInfo' => 'nullable',
            'userData.companyInfo.companyName' => 'nullable',
            'userData.companyInfo.NIP' => 'nullable',
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
