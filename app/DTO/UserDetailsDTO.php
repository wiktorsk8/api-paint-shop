<?php

namespace App\DTO;

class UserDetailsDTO{

    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly int $phone,
        private readonly ?string $companyName,
        private readonly ?int $NIP,
    ){}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function getCompanyName(): string|null
    {
        return $this->companyName;
    }

    public function getNIP(): int|null
    {
        return $this->NIP;
    }
}
