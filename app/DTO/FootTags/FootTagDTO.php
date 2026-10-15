<?php

namespace App\DTO\FootTags;

use App\DTO\BaseDTO;

class FootTagDTO extends BaseDTO
{
    public function __construct(
        private string $type,
        private int $id,
        private string $name,
        private string $link,
    ) {
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
        ];
    }
}
