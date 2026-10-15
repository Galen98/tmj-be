<?php

namespace App\DTO\Tags;

use App\DTO\BaseDTO;
use App\Models\Tag;

class TagDTO extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public ?string $icon,
    ) {
    }

    public static function fromModel(
        Tag $tag
    ): self {
        return new self(
            id: $tag->id,
            name: $tag->name,
            slug: $tag->slug,
            icon: $tag->icon,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->icon,
        ];
    }
}
