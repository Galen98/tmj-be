<?php

namespace App\Repositories\Backgrounds;

use App\Models\Background;
use Illuminate\Database\Eloquent\Collection;

class BackgroundRepository
{
    public function getAll(): Collection
    {
        return Background::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }


    /*
     * Khusus API frontend.
     *
     * Hanya background aktif
     * dan maksimal 3.
     */
    public function getActiveForFrontend(): Collection
    {
        return Background::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(3)
            ->get();
    }


    public function findById(
        int $id
    ): ?Background {
        return Background::find($id);
    }


    public function create(
        array $data
    ): Background {
        return Background::create(
            $data
        );
    }


    public function update(
        Background $background,
        array $data
    ): Background {
        $background->update(
            $data
        );

        return $background->refresh();
    }


    public function delete(
        Background $background
    ): bool {
        return $background->delete();
    }


    public function updateStatus(
        Background $background,
        bool $status
    ): Background {
        $background->update([
            'status' => $status,
        ]);

        return $background->refresh();
    }
}
