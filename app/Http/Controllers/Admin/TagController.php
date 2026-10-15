<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Tags\TagService;
use Illuminate\Http\Request;

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
                ->getAll();

        return view(
            'dashboard.tags.index',
            compact('tags')
        );
    }

    public function updateStatus(
        Request $request,
        int $id
    ) {
        $validated =
            $request->validate([
                'status' => [
                    'required',
                    'boolean',
                ],
            ]);

        $this->tagService
            ->updateStatus(
                $id,
                $validated['status']
            );

        return back()->with(
            'success',
            'Status tag berhasil diperbarui.'
        );
    }
}
