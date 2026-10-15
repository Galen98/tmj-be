<?php

namespace App\DTO\Search;

use App\DTO\BaseDTO;

class SearchSuggestionDTO extends BaseDTO
{
    public function __construct(
        private int $id,
        private string $type,
        private string $name,
        private ?string $description,
        private ?string $image,
        private string $to
    ) {
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'to' => $this->to,
        ];
    }
}