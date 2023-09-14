<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class SavePendingOrderData extends FormRequest
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
            'productId' => ['required', 'numeric', 'min:1', 'max:2147483647'],
            'cartId' => 'required',
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
}
