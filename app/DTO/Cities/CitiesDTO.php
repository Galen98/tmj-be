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
        public float $rating = 0,
        public int $totalReviews = 0,
    ) {
    }

    public static function fromModel(
        City $city,
        array $ratingData = []
    ): self {
        return new self(
            id: $city->id,
            name: $city->name,
            slug: $city->slug,
            description: $city->description,

            image: $city->image
                ? asset(Storage::url($city->image))
                : null,

            rating: (float) ($ratingData['rating'] ?? 0),
            totalReviews: (int) ($ratingData['totalReviews'] ?? 0),
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
            'rating' => $this->rating,
            'totalReviews' => $this->totalReviews,
        ];
    }
}
