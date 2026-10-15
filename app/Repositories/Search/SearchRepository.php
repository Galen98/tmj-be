<?php

namespace App\Repositories\Search;

use App\Models\City;
use App\Models\PointOfInterest;
use App\Models\Travel;

use Illuminate\Database\Eloquent\Collection;

class SearchRepository
{
    /*
     * =========================================
     * SEARCH CITIES
     * =========================================
     */

    public function searchCities(
        string $keyword,
        int $limit = 5
    ): Collection {

        return City::query()
            ->where(function ($query) use ($keyword) {

                $query
                    ->where(
                        'name',
                        'like',
                        '%' . $keyword . '%'
                    )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $keyword . '%'
                    );

            })
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }


    /*
     * =========================================
     * SEARCH POINT OF INTERESTS
     * =========================================
     */

    public function searchPointOfInterests(
        string $keyword,
        int $limit = 5
    ): Collection {

        return PointOfInterest::query()

            /*
             * City dibutuhkan untuk membuat:
             *
             * /point-of-interest/{citySlug}/{poiSlug}
             */

            ->with('city')

            ->where(function ($query) use ($keyword) {

                $query
                    ->where(
                        'name',
                        'like',
                        '%' . $keyword . '%'
                    )
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $keyword . '%'
                    );

            })

            ->orderBy('name')
            ->limit($limit)
            ->get();
    }

    /*
 * =========================================
 * SEARCH TRAVELS
 * =========================================
 */

    public function searchTravels(
        string $keyword,
        int $limit = 5
    ): Collection {

        return Travel::query()
            ->where('status', true)
            ->where(function ($query) use ($keyword) {

                $query
                    ->where(
                        'travel_name',
                        'like',
                        '%' . $keyword . '%'
                    )
                    ->orWhere(
                        'short_description',
                        'like',
                        '%' . $keyword . '%'
                    );

            })
            ->orderBy('travel_name')
            ->limit($limit)
            ->get();
    }
}
