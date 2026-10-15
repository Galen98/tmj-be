<?php

namespace App\DTO\Analytics;

use App\DTO\BaseDTO;

class AnalyticsDTO extends BaseDTO
{
    public function __construct(
        private string $path,
        private ?int $travelId = null
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getTravelId(): ?int
    {
        return $this->travelId;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'travel_id' => $this->travelId,
        ];
    }
}
