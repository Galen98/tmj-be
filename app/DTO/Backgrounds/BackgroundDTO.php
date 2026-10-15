<?php

namespace App\DTO\Backgrounds;

use App\DTO\BaseDTO;
use App\Models\Background;
use Illuminate\Support\Facades\Storage;

class BackgroundDTO extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $image,
    ) {
    }

    public static function fromModel(
        Background $background
    ): self {
        return new self(
            id: $background->id,

            name: $background->name,

            image: asset(
                Storage::url($background->image)
            ),
            //image: Storage::url($background->image)

        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
        ];
    }
}
