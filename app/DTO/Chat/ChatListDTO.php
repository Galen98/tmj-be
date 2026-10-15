<?php

namespace App\DTO\Chat;

use App\DTO\BaseDTO;

class ChatListDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $travel_name,
        public readonly string $message,
        public readonly string $created_at,
        public readonly string $travel_img,
        public readonly bool $is_admin
    ){}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'travelName' => $this->travel_name,
            'message' => $this->message,
            'travelImg' => $this->travel_img,
            'createdAt' => $this->created_at,
            'isAdmin' => $this->is_admin
        ];
    }
}
