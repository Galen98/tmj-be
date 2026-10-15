<?php

namespace App\DTO\Notification;

use App\DTO\BaseDTO;

class NotificationDTO extends BaseDTO
{
     public function __construct(
     public readonly string $id,
     public readonly string $service_name,
     public readonly string $url,
     public readonly bool $is_read,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'serviceName' => $this->service_name,
            'url' => $this->url,
            'isRead' => $this->is_read,
        ];
    }
}
