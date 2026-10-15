<?php

namespace App\Services\Cities;

use App\Models\City;
use App\Repositories\Cities\CityRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CityService
{
    public function __construct(
        protected CityRepository $cityRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->cityRepository
            ->getAll();
    }

    public function getAllActive(): Collection
    {
        return $this->cityRepository
            ->getAllActive();
    }

    public function findById(
        int $id
    ): City {
        $city =
            $this->cityRepository
                ->findById($id);

        abort_if(
            !$city,
            404,
            'City tidak ditemukan.'
        );

        return $city;
    }

    public function findBySlug(
        string $slug
    ): City {
        $city =
            $this->cityRepository
                ->findBySlug($slug);

        abort_if(
            !$city,
            404,
            'City tidak ditemukan.'
        );

        return $city;
    }

    public function create(
        array $data
    ): City {
        $data['slug'] =
            $this->generateUniqueSlug(
                $data['name']
            );

        if (
            isset($data['image']) &&
            $data['image'] instanceof UploadedFile
        ) {
            $data['image'] =
                $this->uploadImage(
                    $data['image']
                );
        }

        $data['status'] =
            $data['status'] ?? false;

        return $this->cityRepository
            ->create($data);
    }

    public function update(
        City $city,
        array $data
    ): City {
        /*
         * Generate slug baru hanya kalau
         * nama city berubah.
         */
        if (
            isset($data['name']) &&
            $data['name'] !== $city->name
        ) {
            $data['slug'] =
                $this->generateUniqueSlug(
                    $data['name'],
                    $city->id
                );
        }

        if (
            isset($data['image']) &&
            $data['image'] instanceof UploadedFile
        ) {
            if ($city->image) {
                Storage::disk('public')
                    ->delete($city->image);
            }

            $data['image'] =
                $this->uploadImage(
                    $data['image']
                );
        }

        $data['status'] =
            $data['status'] ?? false;

        return $this->cityRepository
            ->update(
                $city,
                $data
            );
    }

    public function delete(
        City $city
    ): bool {
        if ($city->image) {
            Storage::disk('public')
                ->delete($city->image);
        }

        return $this->cityRepository
            ->delete($city);
    }

    private function uploadImage(
        UploadedFile $image
    ): string {
        return $image->store(
            'cities',
            'public'
        );
    }

    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug =
            Str::slug($name);

        $slug =
            $baseSlug;

        $counter = 1;

        while (
            City::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) =>
                        $query->where(
                            'id',
                            '!=',
                            $ignoreId
                        )
                )
                ->exists()
        ) {
            $slug =
                $baseSlug .
                '-' .
                $counter;

            $counter++;
        }

        return $slug;
    }
}
