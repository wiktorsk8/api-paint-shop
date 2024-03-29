<?php

namespace App\Services\User;

use App\DTO\AddressDTO;
use App\DTO\UserDetailsDTO;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private User $user;
    private UserDetailsDTO $userDTO;
    private AddressDTO $addressDTO;

    // This method saves user shipping data provided in checkout page. (If user set checkbox to true)
    public function saveUserShippingData(UserDetailsDTO $userDTO, AddressDTO $addressDTO)
    {
        $this->user = Auth::user() ?: throw new Exception("User not authenticated");
        $this->userDTO = $userDTO;
        $this->addressDTO = $addressDTO;
    }

    private function saveNewData() {

    }

    private function updateCurrentData(){

    }

    private function saveUserDetails(){

    }

    private function saveAddress() {

    }
}
