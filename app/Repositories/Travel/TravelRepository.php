<?php

namespace App\Repositories\Travel;

use App\Models\Travel;
use App\Models\TravelAddon;
use App\Models\TravelInclude;
use App\Models\TravelOption;
use App\Models\TravelOptionPrice;
use App\Models\TravelOptionTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TravelRepository
{
    /*
    |--------------------------------------------------------------------------
    | Travel
    |--------------------------------------------------------------------------
    */

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Travel::query()
            ->with([
                'city',
                'pointOfInterest',
            ])
            ->withCount('options')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Travel
    {
        return Travel::create($data);
    }

    public function update(
        Travel $travel,
        array $data
    ): Travel {
        $travel->update($data);

        return $travel->refresh();
    }

    public function delete(Travel $travel): bool
    {
        return (bool) $travel->delete();
    }

    public function loadRelations(Travel $travel): Travel
    {
        return $travel->load([
            'city',
            'pointOfInterest',
            'tags',
            'includes',
            'options.prices',
            'options.times',
            'options.addons',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Tags
    |--------------------------------------------------------------------------
    */

    public function syncTags(
        Travel $travel,
        array $tagIds
    ): void {
        $travel->tags()->sync($tagIds);
    }

    /*
    |--------------------------------------------------------------------------
    | Includes
    |--------------------------------------------------------------------------
    */

    public function createInclude(
        Travel $travel,
        array $data
    ): TravelInclude {
        return $travel->includes()->create($data);
    }

    public function updateInclude(
        TravelInclude $include,
        array $data
    ): TravelInclude {
        $include->update($data);

        return $include;
    }

    public function deleteIncludesNotIn(
        Travel $travel,
        array $ids
    ): void {
        $query = $travel->includes();

        if (!empty($ids)) {
            $query->whereNotIn('id', $ids);
        }

        $query->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    */

    public function createOption(
        Travel $travel,
        array $data
    ): TravelOption {
        return $travel->options()->create($data);
    }

    public function updateOption(
        TravelOption $option,
        array $data
    ): TravelOption {
        $option->update($data);

        return $option;
    }

    public function deleteOptionsNotIn(
        Travel $travel,
        array $ids
    ): void {
        $query = $travel->options();

        if (!empty($ids)) {
            $query->whereNotIn('id', $ids);
        }

        $query->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Option Prices
    |--------------------------------------------------------------------------
    */

    public function createPrice(
        TravelOption $option,
        array $data
    ): TravelOptionPrice {
        return $option->prices()->create($data);
    }

    public function updatePrice(
        TravelOptionPrice $price,
        array $data
    ): TravelOptionPrice {
        $price->update($data);

        return $price;
    }

    public function deletePricesNotIn(
        TravelOption $option,
        array $ids
    ): void {
        $query = $option->prices();

        if (!empty($ids)) {
            $query->whereNotIn('id', $ids);
        }

        $query->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Option Times
    |--------------------------------------------------------------------------
    */

    public function createTime(
        TravelOption $option,
        array $data
    ): TravelOptionTime {
        return $option->times()->create($data);
    }

    public function updateTime(
        TravelOptionTime $time,
        array $data
    ): TravelOptionTime {
        $time->update($data);

        return $time;
    }

    public function deleteTimesNotIn(
        TravelOption $option,
        array $ids
    ): void {
        $query = $option->times();

        if (!empty($ids)) {
            $query->whereNotIn('id', $ids);
        }

        $query->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Addons
    |--------------------------------------------------------------------------
    */

    public function createAddon(
        TravelOption $option,
        array $data
    ): TravelAddon {
        return $option->addons()->create($data);
    }

    public function updateAddon(
        TravelAddon $addon,
        array $data
    ): TravelAddon {
        $addon->update($data);

        return $addon;
    }

    public function deleteAddonsNotIn(
        TravelOption $option,
        array $ids
    ): void {
        $query = $option->addons();

        if (!empty($ids)) {
            $query->whereNotIn('id', $ids);
        }

        $query->delete();
    }

    public function paginateActive(
        int $perPage = 12,
        ?string $search = null,
        ?string $citySlug = null,
        ?string $poiSlug = null,
        ?string $tagSlug = null,
        ?string $sort = null,
        bool $isCorporate = false
    ): LengthAwarePaginator {

        $query = Travel::query()
            ->select('travels.*')
            ->with([
                'city',
                'pointOfInterest',
                'tags',
            ])
            ->where('travels.status', true)
            ->where('travels.is_corporate', $isCorporate)
            ->withCount([
                'activeReviews as total_rating',
            ])
            ->withAvg(
                'activeReviews as average_rating',
                'rating'
            )

            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'travels.travel_name',
                        'like',
                        '%' . $search . '%'
                    )->orWhere(
                        'travels.short_description',
                        'like',
                        '%' . $search . '%'
                    );
                });
            })

            /*
            |--------------------------------------------------------------------------
            | CITY
            |--------------------------------------------------------------------------
            */

            ->when($citySlug, function ($query) use ($citySlug) {
                $query->whereHas('city', function ($q) use ($citySlug) {
                    $q->where('cities.slug', $citySlug);
                });
            })

            /*
            |--------------------------------------------------------------------------
            | POINT OF INTEREST
            |--------------------------------------------------------------------------
            */

            ->when($poiSlug, function ($query) use ($poiSlug) {
                $query->whereHas('pointOfInterest', function ($q) use ($poiSlug) {
                    $q->where('point_of_interests.slug', $poiSlug);
                });
            })

            /*
            |--------------------------------------------------------------------------
            | TAG
            |--------------------------------------------------------------------------
            */

            ->when($tagSlug, function ($query) use ($tagSlug) {
                $query->whereHas('tags', function ($q) use ($tagSlug) {
                    $q->where('tags.slug', $tagSlug);
                });
            });

        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            case 'most-popular':

    $since = now()->subDays(30);

    $viewsQuery = DB::table('analytics')
        ->select('travel_id')
        ->selectRaw('COUNT(*) AS total_views')
        ->whereNotNull('travel_id')
        ->where('created_at', '>=', $since)
        ->groupBy('travel_id');

    $reviewsQuery = DB::table('reviews')
        ->select('travel_id')
        ->selectRaw('COUNT(*) AS total_reviews')
        ->selectRaw('AVG(rating) AS avg_rating')
        // Tambahkan filter review aktif sesuai relasi activeReviews
        ->groupBy('travel_id');

    $query
        ->leftJoinSub(
            $viewsQuery,
            'travel_views',
            function ($join) {
                $join->on(
                    'travel_views.travel_id',
                    '=',
                    'travels.id'
                );
            }
        )
        ->leftJoinSub(
            $reviewsQuery,
            'travel_ratings',
            function ($join) {
                $join->on(
                    'travel_ratings.travel_id',
                    '=',
                    'travels.id'
                );
            }
        )
        ->orderByRaw("
            (
                0.50 * LEAST(
                    LN(1 + COALESCE(travel_views.total_views, 0))
                    / LN(1001),
                    1
                )
                +
                0.35 * (
                    (
                        COALESCE(travel_ratings.avg_rating, 0)
                        * COALESCE(travel_ratings.total_reviews, 0)
                        + 35
                    )
                    /
                    (COALESCE(travel_ratings.total_reviews, 0) + 10)
                    / 5
                )
                +
                0.15 * (
                    CASE
                        WHEN travels.created_at >= ?
                        THEN GREATEST(
                            0,
                            1 - TIMESTAMPDIFF(
                                DAY,
                                travels.created_at,
                                NOW()
                            ) / 30
                        )
                        ELSE 0
                    END
                )
            ) DESC
        ", [$since])
        ->orderByDesc('travels.id');

    break;

            case 'lowest-price':
            case 'price_asc':

                $query->orderBy(
                    'travels.price_now',
                    'asc'
                );

                break;

            case 'highest-price':
            case 'price_desc':

                $query->orderBy(
                    'travels.price_now',
                    'desc'
                );

                break;

            case 'shortest-duration':
            case 'duration_asc':

                $query->orderBy(
                    'travels.duration_hours',
                    'asc'
                );

                break;

            case 'longest-duration':
            case 'duration_desc':

                $query->orderBy(
                    'travels.duration_hours',
                    'desc'
                );

                break;

            default:

                $query->orderBy(
                    'travels.created_at',
                    'desc'
                );

                break;
        }

        return $query
            ->orderBy('travels.id', 'desc')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | API - Detail by Slug
    |--------------------------------------------------------------------------
    */

    public function findActiveBySlug(
    string $slug
): Travel {

    return Travel::query()
        ->with([
            'city',
            'pointOfInterest',
            'tags',

            'includes' => fn ($query) =>
                $query->orderBy('sort_order'),

            'options' => fn ($query) =>
                $query->where('status', true),

            'options.prices' => fn ($query) =>
                $query->where('status', true),

            'options.times' => fn ($query) =>
                $query
                    ->where('status', true)
                    ->where('is_active', true)
                    ->orderBy('time'),

            'options.addons' => fn ($query) =>
                $query->where('status', true),

            /*
             * ACTIVE REVIEWS
             */
            'activeReviews' => fn ($query) =>
                $query->latest(),
        ])

        /*
         * RATING & REVIEW
         */
        ->withCount([
            'activeReviews as total_rating',
        ])

        ->withAvg(
            'activeReviews as average_rating',
            'rating'
        )

        ->where('slug', $slug)
        ->where('status', true)
        ->firstOrFail();
}
}
