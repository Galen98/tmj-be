<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TravelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Basic
            |--------------------------------------------------------------------------
            */

            'id' => $this->id,

            'travel_name' => $this->travel_name,

            'slug' => $this->slug,

            'short_description' => $this->short_description,

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'cities_id' => $this->cities_id,

            'point_of_interest_id' => $this->point_of_interest_id,

            'city' => $this->whenLoaded(
                'city',
                fn () => [
                    'id' => $this->city?->id,
                    'name' => $this->city?->name,
                    'slug' => $this->city?->slug,
                ]
            ),

            'poi' => $this->whenLoaded(
                'pointOfInterest',
                fn () => $this->pointOfInterest
                    ? [
                        'id' => $this->pointOfInterest->id,
                        'name' => $this->pointOfInterest->name,
                        'slug' => $this->pointOfInterest->slug,
                    ]
                    : null
            ),

            /*
            |--------------------------------------------------------------------------
            | Duration
            |--------------------------------------------------------------------------
            */

            'durasi' => $this->duration,

            'satuan_durasi' => $this->duration_type,

            /*
            |--------------------------------------------------------------------------
            | Type / Setting
            |--------------------------------------------------------------------------
            */

            'is_pickup' => (bool) $this->is_pickup,

            'pickup_venue' => $this->pickup_venue,

            'is_corporate' => (bool) $this->is_corporate,

            'is_group' => (bool) $this->is_group,

            'jumlahPeserta' => $this->jumlah_peserta,

            'is_children' => (bool) $this->is_children,

            /*
            |--------------------------------------------------------------------------
            | Price
            |--------------------------------------------------------------------------
            */

            'is_discount' => (bool) $this->is_discount,

            'price_now' => (float) $this->price_now,

            'price_discount' => $this->price_discount !== null
                ? (float) $this->price_discount
                : null,

            /*
            |--------------------------------------------------------------------------
            | Rating & Review
            |--------------------------------------------------------------------------
            |
            | Nilai berasal dari reviews yang status = true.
            | average_rating dihitung melalui withAvg().
            | total_rating dihitung melalui withCount().
            |
            */

            'rating' => round(
                (float) ($this->average_rating ?? 0),
                1
            ),

            'total_rating' => (int) (
                $this->total_rating ?? 0
            ),

            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */

            'image1' => $this->imageUrl(
                $this->image1
            ),
            // 'image1' =>
            //     $this->image1
            // ,

            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            'tags' => $this->whenLoaded(
                'tags',
                fn () => $this->tags->map(
                    fn ($tag) => [
                        'id' => $tag->id,
                        'name' => $tag->name,
                        'slug' => $tag->slug,
                    ]
                )
            ),

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => (bool) $this->status,
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

        return Storage::disk('public')->url($path);
    }
}
