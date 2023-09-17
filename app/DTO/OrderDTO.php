<?php

namespace App\DTO;

use App\DTO\UserDetailsDTO;
use App\DTO\AddressDTO;

class OrderDTO{

    public function __construct(
        private readonly UserDetailsDTO $userDTO,
        private readonly AddressDTO $addressDTO,
        private readonly string $paymentMethod,
        private readonly string $deliveryMethod,
        private readonly array $productIds,
        private readonly string $paymentIntentId
    ){}

    public function getUserDTO(): UserDetailsDTO{
        return $this->userDTO;
    }

    public function getAddressDTO(): AddressDTO {
        return $this->addressDTO;
    }

    public function getPaymentMethod(): string {
        return $this->paymentMethod;
    }

    public function getDeliveryMethod(): string {
        return $this->deliveryMethod;
    }

    public function getProductIds(): array {
        return $this->productIds;
    }

    public function getPaymentIntentId(): string {
        return $this->paymentIntentId;
    }
}