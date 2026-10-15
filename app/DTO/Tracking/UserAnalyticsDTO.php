<?php

namespace App\DTO\Tracking;

use App\DTO\BaseDTO;


//page name => Home, Travel Detail, Search, Booking, City
class UserAnalyticsDTO extends BaseDTO
{
    public function __construct(
        public readonly string $ip_address,
        public readonly int $travel_item_id,
        public readonly string $page_name,
        public readonly string $link,
        public readonly string $date_opened,
        public readonly string $travel_name,
        public readonly string $details,
    ){}

    public function toArray(): array
    {
        return [
            'ip_address' => $this->ip_address,
            'travel_item_id' => $this->travel_item_id,
            'link' => $this->link,
            'page_name' => $this->page_name,
            'date_opened' => $this->date_opened,
            'travel_name' => $this->travel_name,
            'details' => $this->details
        ];
    }
}
