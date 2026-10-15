<?php

namespace App\Services\PointOfInterests;

use App\Models\PointOfInterest;
use App\Repositories\PointOfInterests\PointOfInterestRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PointOfInterestService
{
    public function __construct(
        protected PointOfInterestRepository $repository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->repository
            ->getAll();
    }

    public function getAllActive(): Collection
    {
        return $this->repository
            ->getAllActive();
    }

    public function findById(
        int $id
    ): PointOfInterest {
        $pointOfInterest =
            $this->repository
                ->findById($id);

        abort_if(
            !$pointOfInterest,
            404,
            'Point of Interest tidak ditemukan.'
        );

        return $pointOfInterest;
    }

    public function findBySlug(
        string $slug
    ): PointOfInterest {
        $pointOfInterest =
            $this->repository
                ->findBySlug($slug);

        abort_if(
            !$pointOfInterest,
            404,
            'Point of Interest tidak ditemukan.'
        );

        return $pointOfInterest;
    }

    public function create(
        array $data
    ): PointOfInterest {
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

        return $this->repository
            ->create($data);
    }

    public function update(
        PointOfInterest $pointOfInterest,
        array $data
    ): PointOfInterest {
        if (
            isset($data['name']) &&
            $data['name'] !==
                $pointOfInterest->name
        ) {
            $data['slug'] =
                $this->generateUniqueSlug(
                    $data['name'],
                    $pointOfInterest->id
                );
        }

        if (
            isset($data['image']) &&
            $data['image'] instanceof UploadedFile
        ) {
            if ($pointOfInterest->image) {
                Storage::disk('public')
                    ->delete(
                        $pointOfInterest->image
                    );
            }

            $data['image'] =
                $this->uploadImage(
                    $data['image']
                );
        }

        $data['status'] =
            $data['status'] ?? false;

        return $this->repository
            ->update(
                $pointOfInterest,
                $data
            );
    }

    public function delete(
        PointOfInterest $pointOfInterest
    ): bool {
        if ($pointOfInterest->image) {
            Storage::disk('public')
                ->delete(
                    $pointOfInterest->image
                );
        }

        return $this->repository
            ->delete(
                $pointOfInterest
            );
    }

    private function uploadImage(
        UploadedFile $image
    ): string {
        return $image->store(
            'point-of-interests',
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
            $this->repository
                ->slugExists(
                    $slug,
                    $ignoreId
                )
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
