<?php

namespace App\DTO;

class OrderDTO{

    public function __construct(
        private readonly array $product_id,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly int $phone,
        private readonly string $city,
        private readonly string $postalCode,
        private readonly string $streetName,
        private readonly int $streetNumber, 
        private readonly ?int $flatNumber,
        private readonly ?string $companyName,
        private readonly ?int $NIP,
        private readonly ?string $extraInfo,
    ){}

    public function getFirstName(): string{
        return $this->firstName;
    }

    public function getLastName(): string{
        return $this->lastName;
    }

    public function getEmail(): string{
        return $this->email;
    }
    public function getPhone(): int{
        return $this->phone;
    }
    public function getProductId(): array{
        return $this->product_id;
    }

    public function getCity(): string{
        return $this->city;
    }

    public function getPostalCode(): string{
        return $this->postalCode;
    }

    public function getStreetName(): string{
        return $this->streetName;
    }

    public function getStreetNumber(): int{
        return $this->streetNumber;
    }

    public function getFlatNumber(){
        return $this->flatNumber;
    }
    public function getCompanyName(){
        return $this->companyName;
    }
    public function getNIP(){
        return $this->NIP;
    }

    public function getExtraInfo(){
        return $this->extraInfo;
    }
}
