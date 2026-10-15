<?php

namespace App\Services\Analytics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoLocationService
{
    public function lookup(
        ?string $ip
    ): array {

        /*
         * Default response.
         */

        $location = [
            'country' => null,
            'province' => null,
        ];


        /*
         * IP tidak tersedia.
         */

        if (!$ip) {
            return $location;
        }


        /*
         * Localhost/private IP tidak bisa
         * dicari menggunakan GeoIP publik.
         */

        if ($this->isPrivateIp($ip)) {
            return $location;
        }


        try {

            $response = Http::timeout(3)
                ->acceptJson()
                ->get(
                    config('services.geoip.url') .
                    '/' .
                    urlencode($ip)
                );


            if (!$response->successful()) {

                return $location;

            }


            $data = $response->json();


            return [
                'country' =>
                    $data['country_name']
                    ?? $data['country']
                    ?? null,

                'province' =>
                    $data['region']
                    ?? null,
            ];

        } catch (\Throwable $e) {

            /*
             * GeoIP tidak boleh membuat
             * analytics utama gagal.
             */

            Log::warning(
                'GeoIP lookup failed',
                [
                    'ip' => $ip,
                    'message' => $e->getMessage(),
                ]
            );


            return $location;
        }
    }


    private function isPrivateIp(
        string $ip
    ): bool {

        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE |
            FILTER_FLAG_NO_RES_RANGE
        ) === false;
    }
}
