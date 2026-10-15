<?php

namespace App\DTO\EmailCustomers;

use App\DTO\BaseDTO;

class EmailCustomerDTO extends BaseDTO
{
    public function __construct(
        private string $email
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
