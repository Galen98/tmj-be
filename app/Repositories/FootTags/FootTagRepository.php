<?php

namespace App\Repositories\FootTags;

use App\Models\City;
use App\Models\PointOfInterest;
use App\Models\Tag;

class FootTagRepository
{
    public function getCities()
    {
        return City::query()
            ->select([
                'id',
                'name',
                'slug',
            ])
            ->orderBy('name')
            ->get();
    }


    public function getPointOfInterests()
    {
        return PointOfInterest::query()
            ->with([
                'city:id,name,slug',
            ])
            ->select([
                'id',
                'city_id',
                'name',
                'slug',
            ])
            ->orderBy('name')
            ->get();
    }


    public function getTags()
    {
        return Tag::query()

            /*
             * Sesuaikan dengan field enable/disable
             * yang kita buat sebelumnya.
             */

            ->where('status', true)

            ->select([
                'id',
                'name',
                'slug',
            ])

            ->orderBy('name')
            ->get();
    }
}
