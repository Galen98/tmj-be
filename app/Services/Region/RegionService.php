<?php

namespace App\Services\Region;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class RegionService
{
    private string $baseUrl = 'https://wilayah.id/api';

    public function getProvinces(): array
    {
        return Cache::remember(
            'regions.provinces',
            now()->addDay(),
            function () {

                $response = Http::timeout(10)
                    ->get(
                        "{$this->baseUrl}/provinces.json"
                    );

                if ($response->failed()) {
                    throw new RuntimeException(
                        'Gagal mengambil data provinsi.'
                    );
                }

                return $response->json('data') ?? [];
            }
        );
    }


    public function getRegencies(
        string $provinceCode
    ): array {
        return Cache::remember(
            "regions.regencies.{$provinceCode}",
            now()->addDay(),
            function () use ($provinceCode) {

                $response = Http::timeout(10)
                    ->get(
                        "{$this->baseUrl}/regencies/{$provinceCode}.json"
                    );

                if ($response->failed()) {
                    throw new RuntimeException(
                        'Gagal mengambil data kota/kabupaten.'
                    );
                }

                return $response->json('data') ?? [];
            }
        );
    }
}
