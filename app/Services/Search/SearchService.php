<?php

namespace App\Services\Search;

use App\DTO\Search\SearchSuggestionDTO;
use App\Repositories\Search\SearchRepository;
use Illuminate\Support\Facades\Storage;

class SearchService
{
    public function __construct(
        private SearchRepository $repository
    ) {
    }


    /*
     * =========================================
     * SEARCH SUGGESTIONS
     * =========================================
     */

    public function suggestions(
        string $keyword
    ): array {

        /*
         * =========================================
         * CITY
         * =========================================
         */

        $cities =
            $this->repository
                ->searchCities(
                    $keyword,
                    5
                );


        $cityResults =
            $cities->map(
                function ($city) {

                    $dto =
                        new SearchSuggestionDTO(
                            id: $city->id,

                            type: 'city',

                            name: $city->name,

                            description:
                                $city->description,

                            image:
                                $this->getImageUrl(
                                    $city->image
                                ),
                            // image:
                            //         $city->image
                            //     ,

                            to:
                                '/city/' .
                                $city->slug
                        );


                    return $dto->toArray();
                }
            );


        /*
         * =========================================
         * POINT OF INTEREST
         * =========================================
         */

        $pointOfInterests =
            $this->repository
                ->searchPointOfInterests(
                    $keyword,
                    5
                );


        $poiResults =
            $pointOfInterests->map(
                function ($poi) {

                    /*
                     * Kalau city tidak ditemukan,
                     * POI tidak kita keluarkan karena
                     * URL membutuhkan city slug.
                     */

                    if (!$poi->city) {
                        return null;
                    }


                    $dto =
                        new SearchSuggestionDTO(
                            id: $poi->id,

                            type: 'poi',

                            name: $poi->name,

                            description:
                                $poi->description,

                            image:
                                $this->getImageUrl(
                                    $poi->image
                                ),
                            // image:
                            //         $poi->image
                            //     ,

                            to:
                                '/point-of-interest/' .
                                $poi->city->slug .
                                '/' .
                                $poi->slug
                        );


                    return $dto->toArray();
                }
            )
            ->filter()
            ->values();

            /*
 * =========================================
 * TRAVEL
 * =========================================
 */

$travels =
    $this->repository
        ->searchTravels(
            $keyword,
            5
        );


$travelResults =
    $travels->map(
        function ($travel) {

            $dto =
                new SearchSuggestionDTO(
                    id: $travel->id,

                    type: 'travel',

                    name:
                        $travel->travel_name,

                    description:
                        $travel->short_description,

                    image:
                        $this->getImageUrl(
                            $travel->image1
                        ),

                    to:
                        '/travel/' .
                        $travel->slug
                );


            return $dto->toArray();
        }
    );


        /*
         * =========================================
         * MERGE
         * =========================================
         */

       return $cityResults
        ->concat($poiResults)
        ->concat($travelResults)
        ->values()
        ->toArray();
    }


    /*
     * =========================================
     * IMAGE URL
     * =========================================
     */

    private function getImageUrl(
        ?string $image
    ): ?string {

        if (!$image) {
            return null;
        }


        /*
         * Kalau sudah URL lengkap.
         */

        if (
            str_starts_with(
                $image,
                'http://'
            ) ||
            str_starts_with(
                $image,
                'https://'
            )
        ) {
            return $image;
        }


        /*
         * Kalau DB menyimpan:
         *
         * cities/xxx.jpg
         *
         * atau:
         *
         * point-of-interests/xxx.jpg
         */

        return url(
            Storage::url(
                $image
            )
        );
    }
}
