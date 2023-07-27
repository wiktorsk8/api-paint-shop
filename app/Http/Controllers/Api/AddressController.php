<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;

class AddressController extends Controller
{
    public function view(Address $address){
        return new AddressResource($address);
    }

    public function store(StoreAddressRequest $request){
        $address = Address::create($request->validated());

        return new AddressResource($address);
    }
}
