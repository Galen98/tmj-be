<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TravelDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | Basic
            |--------------------------------------------------------------------------
            */

            'id' =>
                $this->id,

            'travel_name' =>
                $this->travel_name,

            'slug' =>
                $this->slug,

            'short_description' =>
                $this->short_description,

            'full_description' =>
                $this->full_description,


            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'cities_id' =>
                $this->cities_id,

            'point_of_interest_id' =>
                $this->point_of_interest_id,

            'city' => $this->whenLoaded(
                'city',
                fn () => [
                    'id' =>
                        $this->city?->id,

                    'name' =>
                        $this->city?->name,

                    'slug' =>
                        $this->city?->slug,
                ]
            ),

            'poi' => $this->whenLoaded(
                'pointOfInterest',
                fn () => $this->pointOfInterest
                    ? [
                        'id' =>
                            $this->pointOfInterest->id,

                        'name' =>
                            $this->pointOfInterest
                                ->name,

                        'slug' =>
                            $this->pointOfInterest->slug,
                    ]
                    : null
            ),


            /*
            |--------------------------------------------------------------------------
            | Duration
            |--------------------------------------------------------------------------
            */

            'durasi' =>
                $this->duration,

            'satuan_durasi' =>
                $this->duration_type,


            /*
            |--------------------------------------------------------------------------
            | Settings
            |--------------------------------------------------------------------------
            */

            'is_pickup' =>
                (bool) $this->is_pickup,

            'pickup_venue' =>
                $this->pickup_venue,

            'is_corporate' =>
                (bool) $this->is_corporate,

            'is_group' =>
                (bool) $this->is_group,

            'jumlahPeserta' =>
                $this->jumlah_peserta,

            'is_children' =>
                (bool) $this->is_children,


            /*
            |--------------------------------------------------------------------------
            | Price
            |--------------------------------------------------------------------------
            */

            'is_discount' =>
                (bool) $this->is_discount,

            'price_now' =>
                (float) $this->price_now,

            'price_discount' =>
                $this->price_discount !== null
                    ? (float) $this->price_discount
                    : null,


            /*
            |--------------------------------------------------------------------------
            | Rating
            |--------------------------------------------------------------------------
            */

            /*
            |--------------------------------------------------------------------------
            | Rating & Reviews
            |--------------------------------------------------------------------------
            */

            'rating' => round(
                (float) ($this->average_rating ?? 0),
                1
            ),

            'total_rating' => (int) (
                $this->total_rating ?? 0
            ),

            'reviews' => ReviewResource::collection(
                $this->whenLoaded('activeReviews')
            ),

            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            'image1' =>
                $this->imageUrl(
                    $this->image1
                ),

            'image2' =>
                $this->imageUrl(
                    $this->image2
                ),

            'image3' =>
                $this->imageUrl(
                    $this->image3
                ),

            'image4' =>
                $this->imageUrl(
                    $this->image4
                ),

            'image5' =>
                $this->imageUrl(
                    $this->image5
                ),

        //     'image1' =>

        //             $this->image1
        //         ,

        //     'image2' =>

        //             $this->image2
        //         ,

        //     'image3' =>

        //             $this->image3
        //         ,

        //     'image4' =>

        //             $this->image4
        //         ,

        //     'image5' =>

        //             $this->image5

        // ,

            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            'tags' => $this->whenLoaded(
                'tags',
                fn () =>
                    $this->tags->map(
                        fn ($tag) => [
                            'id' =>
                                $tag->id,

                            'name' =>
                                $tag->name,

                            'slug' =>
                                $tag->slug,
                        ]
                    )
            ),


            /*
            |--------------------------------------------------------------------------
            | Includes
            |--------------------------------------------------------------------------
            */

            'includes' => $this->whenLoaded(
                'includes',
                fn () =>
                    $this->includes->map(
                        fn ($include) => [
                            'id' =>
                                $include->id,

                            'include_desc' =>
                                $include->include_desc,
                        ]
                    )
            ),


            /*
            |--------------------------------------------------------------------------
            | Options
            |--------------------------------------------------------------------------
            */

            'options' => $this->whenLoaded(
                'options',
                fn () =>
                    $this->options->map(
                        fn ($option) => [
                            'id' =>
                                $option->id,

                            'option_name' =>
                                $option->option_name,

                            'description' =>
                                $option->description,

                            'prices' =>
                                $option->prices->map(
                                    fn ($price) => [
                                        'id' =>
                                            $price->id,

                                        'type' =>
                                            $price->type,

                                        'label' =>
                                            $price->label,

                                        'min' =>
                                            $price->min,

                                        'max' =>
                                            $price->max,

                                        'price' =>
                                            (float) $price->price,
                                    ]
                                )->values(),

                            'times' =>
                                $option->times->map(
                                    fn ($time) => [
                                        'id' =>
                                            $time->id,

                                        'time' =>
                                            substr(
                                                $time->time,
                                                0,
                                                5
                                            ),

                                        'is_active' =>
                                            (bool)
                                            $time->is_active,
                                    ]
                                )->values(),

                            'addons' =>
                                $option->addons->map(
                                    fn ($addon) => [
                                        'id' =>
                                            $addon->id,

                                        'addon_name' =>
                                            $addon->addon_name,

                                        'description' =>
                                            $addon->description,

                                        'price' =>
                                            (float)
                                            $addon->price,

                                        'min' =>
                                            $addon->min,

                                        'max' =>
                                            $addon->max,
                                    ]
                                )->values(),
                        ]
                    )
            ),

            'status' =>
                (bool) $this->status,
        ];
    }

    private function imageUrl(
        ?string $path
    ): ?string {
        if (!$path) {
            return null;
        }

        if (
            str_starts_with(
                $path,
                'http://'
            ) ||
            str_starts_with(
                $path,
                'https://'
            )
        ) {
            return $path;
        }

        return Storage::disk('public')
            ->url($path);
    }
}
