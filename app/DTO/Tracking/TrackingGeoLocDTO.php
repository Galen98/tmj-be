<?php

namespace App\DTO\Tracking;

use App\DTO\BaseDTO;

class TrackingGeoLocDTO extends BaseDTO
{
        public function __construct(
        public readonly string $id,
        public readonly string $ip_address,
        public readonly string $location,
        public readonly string $description,
        public readonly string $details,
        ) {}

        public function toArray(): array
        {
            return [
                'id' => $this->id,
                'ipAddress' => $this->ip_address,
                'location' => $this->location,
                'description' => $this->description,
                'details' => $this->details,
            ];
        }
}
