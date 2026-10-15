<?php

use App\DTO\BaseDTO;

class UserActivitiesDTO extends BaseDTO
{
    public function __construct(
        public readonly string $ip_address,
        public readonly int $total_visits,
        public readonly string $last_opened,
        public readonly string $first_opened
    ){}

    public function toArray(): array
    {
        return [
            'ipAddress' => $this->ip_address,
            'totalVisits' => $this->total_visits,
            'lastOpened' => $this->last_opened,
            'firstOpened' => $this->first_opened
        ];
    }
}
