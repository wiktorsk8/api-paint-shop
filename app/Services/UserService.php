<?php

namespace App\Services;

use App\DTO\UserInfoDTO;
use App\Http\Requests\User\SaveShippingInfoRequest;
use App\Models\Address;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserService
{
    protected User $user;

    public function saveUserShippingInfo(SaveShippingInfoRequest $request)
    {
        $this->user = Auth::user();
        $dto = new UserInfoDTO(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->phone,
            $request->city,
            $request->postal_code,
            $request->street_name,
            $request->street_number,
            $request->flat_number,
            $request->company_name,
            $request->NIP,
            $request->extra_info
        );

        // Check only for user_details table, because addresses and 
        // user_details are created allways at the same time so 
        // double check is not required.
        if (!UserDetails::where('user_id', '=', $this->user->id)->exists()) {
            $this->storeNewData($dto);

            return $this->user;
        }

        $this->updateCurrentData($dto);
        return $this->user;
    }

    private function updateCurrentData(UserInfoDTO $dto)
    {
        $details = UserDetails::where('user_id', '=', $this->user->id)->first();
        $address = Address::where('user_id', '=', $this->user->id)->first();

        $fillDetails = function (UserInfoDTO $dto): array {
            $data = [];
            if ($dto->getPhone() != null) $data['phone'] = $dto->getPhone();
            if ($dto->getFirstName() != null) $data['first_name'] = $dto->getFirstName();
            if ($dto->getLastName() != null) $data['last_name'] = $dto->getLastName();

            return $data;
        };

        $fillAddress = function (UserInfoDTO $dto): array {
            $data = [];

            if ($dto->getCity() != null) $data['city'] = $dto->getCity();
            if ($dto->getPostalCode() != null) $data['postal_code'] = $dto->getPostalCode();
            if ($dto->getStreetName() != null) $data['street_name'] = $dto->getStreetName();
            if ($dto->getStreetNumber() != null) $data['street_number'] = $dto->getStreetNumber();
            if ($dto->getFlatNumber() != null) $data['flat_number'] = $dto->getFlatNumber();
            if ($dto->getCompanyName() != null) $data['company_name'] = $dto->getCompanyName();
            if ($dto->getNIP() != null) $data['NIP'] = $dto->getNIP();

            return $data;
        };

        $details->update($fillDetails($dto));
        $address->update($fillAddress($dto));
    }

    private function storeNewData(UserInfoDTO $dto)
    {
        UserDetails::create([
            'user_id' => $this->user->id,
            'phone' => $dto->getPhone(),
            'first_name' => $dto->getFirstName(),
            'last_name' => $dto->getLastName()
        ]);

        Address::create([
            'user_id' => $this->user->id,
            'city' => $dto->getCity(),
            'postal_code' => $dto->getPostalCode(),
            'street_name' => $dto->getStreetName(),
            'street_number' => $dto->getStreetNumber(),
            'flat_number' => $dto->getFlatNumber(),
            'company_name' => $dto->getCompanyName(),
            'NIP' => $dto->getNIP(),
            'extra_info' => $dto->getExtraInfo(),
        ]);

        if ($this->user->email != $dto->getEmail()) {
            $this->user->email = $dto->getEmail();
            $this->user->save();
        }
    }
}
