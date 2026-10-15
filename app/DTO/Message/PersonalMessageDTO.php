<?php

namespace App\DTO\Message;

use App\DTO\BaseDTO;

class PersonalMessageDTO extends BaseDTO
{
    public function __construct(
    public readonly string $name,
    public readonly string $email,
    public readonly string $message,
    public readonly bool $is_admin = false,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'is_admin' => $this->is_admin,
        ];
    }
}
