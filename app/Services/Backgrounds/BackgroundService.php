<?php

namespace App\Services\Backgrounds;

use App\Models\Background;
use App\Repositories\Backgrounds\BackgroundRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BackgroundService
{
    public function __construct(
        protected BackgroundRepository $repository
    ) {
    }


    public function getAll(): Collection
    {
        return $this->repository
            ->getAll();
    }


    public function getActiveForFrontend(): Collection
    {
        return $this->repository
            ->getActiveForFrontend();
    }


    public function findById(
        int $id
    ): Background {
        $background =
            $this->repository
                ->findById($id);

        abort_if(
            !$background,
            404,
            'Background tidak ditemukan.'
        );

        return $background;
    }


    public function create(
        array $data
    ): Background {

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

        $data['sort_order'] =
            $data['sort_order'] ?? 0;


        return $this->repository
            ->create($data);
    }


    public function update(
        Background $background,
        array $data
    ): Background {

        if (
            isset($data['image']) &&
            $data['image'] instanceof UploadedFile
        ) {

            /*
             * Hapus gambar lama.
             */

            if ($background->image) {

                Storage::disk('public')
                    ->delete(
                        $background->image
                    );

            }


            /*
             * Upload gambar baru.
             */

            $data['image'] =
                $this->uploadImage(
                    $data['image']
                );

        }


        $data['status'] =
            $data['status'] ?? false;


        return $this->repository
            ->update(
                $background,
                $data
            );
    }


    public function updateStatus(
        int $id,
        bool $status
    ): Background {

        $background =
            $this->findById($id);


        return $this->repository
            ->updateStatus(
                $background,
                $status
            );
    }


    public function delete(
        Background $background
    ): bool {

        if ($background->image) {

            Storage::disk('public')
                ->delete(
                    $background->image
                );

        }


        return $this->repository
            ->delete(
                $background
            );
    }


    private function uploadImage(
        UploadedFile $image
    ): string {

        return $image->store(
            'backgrounds',
            'public'
        );

    }
}
