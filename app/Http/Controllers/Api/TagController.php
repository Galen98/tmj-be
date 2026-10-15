<?php

namespace App\Http\Controllers\Api;

use App\DTO\Tags\TagDTO;
use App\Http\Controllers\Controller;
use App\Services\Tags\TagService;

class TagController extends Controller
{
    public function __construct(
        protected TagService $tagService
    ) {
    }

    public function index()
    {
        $tags =
            $this->tagService
                ->getAllActive();

        $data =
            $tags->map(
                fn ($tag) =>
                    TagDTO::fromModel(
                        $tag
                    )->toArray()
            )->values();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
