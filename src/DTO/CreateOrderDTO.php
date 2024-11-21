<?php

namespace Aldar\Project2\DTO;

class CreateOrderDTO
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $address,
        private string $phone,
        private string $date,
        private int $userId
    )
    {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

}