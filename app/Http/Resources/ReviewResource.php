<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'travel_id' => $this->travel_id,

            'cust_name' => $this->cust_name,
            'asal_kota' => $this->asal_kota,
            'description' => $this->description,

            'rating' => (int) $this->rating,

            'image1' => $this->imageUrl($this->image1),
            'image2' => $this->imageUrl($this->image2),
            'image3' => $this->imageUrl($this->image3),
            'image4' => $this->imageUrl($this->image4),
            'image5' => $this->imageUrl($this->image5),

            'created_at' => $this->created_at,
        ];
    }

    private function imageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (
            str_starts_with($path, 'http://') ||
            str_starts_with($path, 'https://')
        ) {
            return $path;
        }

        return url(Storage::url($path));
    }
}
