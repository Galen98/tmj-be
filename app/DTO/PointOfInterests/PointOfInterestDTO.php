<?php

namespace App\DTO\PointOfInterests;

use App\DTO\BaseDTO;
use App\Models\PointOfInterest;

class PointOfInterestDTO extends BaseDTO
{
    public function __construct(
        protected PointOfInterest $pointOfInterest
    ) {
    }


    public static function fromModel(
        PointOfInterest $pointOfInterest
    ): self {
        return new self(
            $pointOfInterest
        );
    }


    public function toArray(): array
    {
        return [
            'id' =>
                $this->pointOfInterest->id,

            'cityId' =>
                $this->pointOfInterest->city_id,

            'cityName' =>
                $this->pointOfInterest->city?->name,

            'citySlug' =>
                $this->pointOfInterest->city?->slug,

            'name' =>
                $this->pointOfInterest->name,

            'slug' =>
                $this->pointOfInterest->slug,

            'description' =>
                $this->pointOfInterest->description,

            'image' =>
                $this->pointOfInterest->image
                    ? asset(
                        'storage/' .
                        $this->pointOfInterest->image
                    )
                    : null,
            // 'image' =>
            //     $this->pointOfInterest->image
            //         ? '/storage/' . $this->pointOfInterest->image
            //         : null,
        ];
    }
}
