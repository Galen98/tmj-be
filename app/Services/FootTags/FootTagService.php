<?php

namespace App\Services\FootTags;

use App\DTO\FootTags\FootTagDTO;
use App\Repositories\FootTags\FootTagRepository;

class FootTagService
{
    public function __construct(
        private FootTagRepository $repository
    ) {
    }


    public function getAll(): array
    {
        $data = [];


        /*
         * =========================================
         * POINT OF INTEREST
         * =========================================
         */

        $pointOfInterests =
            $this->repository
                ->getPointOfInterests();


        foreach ($pointOfInterests as $poi) {

            /*
             * POI tanpa city tidak bisa membentuk
             * URL yang valid.
             */

            if (!$poi->city) {
                continue;
            }


            $dto = new FootTagDTO(

                type:
                    'point-of-interest',

                id:
                    $poi->id,

                name:
                    $poi->name,

                link:
                    '/point-of-interest/' .
                    $poi->city->slug .
                    '/' .
                    $poi->slug,

            );


            $data[] =
                $dto->toArray();
        }


        /*
         * =========================================
         * CITY
         * =========================================
         */

        $cities =
            $this->repository
                ->getCities();


        foreach ($cities as $city) {

            $dto = new FootTagDTO(

                type:
                    'city',

                id:
                    $city->id,

                name:
                    $city->name,

                link:
                    '/city/' .
                    $city->slug,

            );


            $data[] =
                $dto->toArray();
        }


        /*
         * =========================================
         * TAG
         * =========================================
         */

        $tags =
            $this->repository
                ->getTags();


            foreach ($tags as $tag) {

        /*
        * Korporasi punya halaman khusus.
        */

        if ($tag->slug === 'korporasi') {

            $link = '/korporasi';

        } else {

            $link =
                '/recommendations?filter=' .
                urlencode($tag->slug);

        }


        $dto = new FootTagDTO(

            type: 'tag',

            id: $tag->id,

            name: $tag->name,

            link: $link,

        );


        $data[] =
            $dto->toArray();
    }


        return $data;
    }
}
