<?php

namespace App\Repositories\Tags;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository
{
    public function getAll(): Collection
    {
        return Tag::query()
            ->orderBy('id')
            ->get();
    }

    public function getAllActive(): Collection
    {
        return Tag::query()
            ->where('status', true)
            ->orderBy('id')
            ->get();
    }

    public function findById(
        int $id
    ): ?Tag {
        return Tag::find($id);
    }

    public function updateStatus(
        Tag $tag,
        bool $status
    ): Tag {
        $tag->update([
            'status' => $status,
        ]);

        return $tag->refresh();
    }
}
