<?php

namespace App\DTO;

class AddressDTO{

    public function __construct(
        private readonly string $street,
        private readonly string $buildingNumber,
        private readonly string $city,
        private readonly string $postalCode,
        private readonly string $countryCode,
        private readonly ?string $extraInfo,
    ){}

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getBuildingNumber(): string
    {
        return $this->buildingNumber;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getExtraInfo(): string|null
    {
        return $this->extraInfo;
    }
}