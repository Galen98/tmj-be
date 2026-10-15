<?php

namespace App\Repositories\Analytics;

use App\Models\Analytics;

class AnalyticsRepository
{
    public function create(
        array $data
    ): Analytics {

        return Analytics::create(
            $data
        );
    }
}
