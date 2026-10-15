<?php

namespace App\DTO\Cities;

use App\DTO\BaseDTO;
use App\Models\City;
use Illuminate\Support\Facades\Storage;

class CitiesDTO extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public ?string $description,
        public ?string $image,
    ) {
    }

    public static function fromModel(
        City $city
    ): self {
        return new self(
            id: $city->id,
            name: $city->name,
            slug: $city->slug,
            description: $city->description,

            image: $city->image
                ? asset(Storage::url($city->image))
                // ? Storage::url($city->image)
                : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
        ];
    }
}
