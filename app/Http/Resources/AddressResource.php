<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'street_name' => $this->street_name,
            'street_number' => $this->street_number,
            'flat_number' => $this->flat_number,
            'company_name' => $this->company_name,
            'NIP' => $this->NIP,
            'extra_info' => $this->extra_info
        ];
    }
}
