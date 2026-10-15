<?php

namespace App\Services\Tags;

use App\Models\Tag;
use App\Repositories\Tags\TagRepository;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function __construct(
        protected TagRepository $repository
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
    ): Tag {
        $tag =
            $this->repository
                ->findById($id);

        abort_if(
            !$tag,
            404,
            'Tag tidak ditemukan.'
        );

        return $tag;
    }

    public function updateStatus(
        int $id,
        bool $status
    ): Tag {
        $tag =
            $this->findById($id);

        return $this->repository
            ->updateStatus(
                $tag,
                $status
            );
    }
}
