<?php

namespace App\Services\Analytics;

use App\DTO\Analytics\AnalyticsDTO;
use App\Models\Analytics;
use App\Repositories\Analytics\AnalyticsRepository;
use App\Repositories\UserTokens\UserTokenRepository;
use Illuminate\Http\Request;

class AnalyticsService
{
    public function __construct(
        private AnalyticsRepository $analyticsRepository,
        private UserTokenRepository $userTokenRepository,
        private GeoLocationService $geoLocationService
    ) {
    }

    public function track(
        AnalyticsDTO $dto,
        Request $request
    ): Analytics {

        /*
         * =========================================
         * USER TOKEN
         * =========================================
         */

        $token =
            $request->header(
                'X-User-Token'
            );

        $userToken = null;

        if ($token) {

            $userToken =
                $this->userTokenRepository
                    ->findByToken(
                        $token
                    );
        }


        /*
         * =========================================
         * IP ADDRESS
         * =========================================
         */

        $ipAddress =
            $request->ip();


        /*
         * =========================================
         * GEO LOCATION
         * =========================================
         */

        $location =
            $this->geoLocationService
                ->lookup(
                    $ipAddress
                );


        /*
         * =========================================
         * SAVE ANALYTICS
         * =========================================
         */

        return $this
            ->analyticsRepository
            ->create([

                'user_token_id' =>
                    $userToken?->id,

                'travel_id' =>
                    $dto->getTravelId(),

                'ip_address' =>
                    $ipAddress,

                'path' =>
                    $dto->getPath(),

                'country' =>
                    $location['country'],

                'province' =>
                    $location['province'],

                'user_agent' =>
                    $request->userAgent(),

            ]);
    }
}
