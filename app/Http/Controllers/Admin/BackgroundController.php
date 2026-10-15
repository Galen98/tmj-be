<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backgrounds\StoreBackgroundRequest;
use App\Http\Requests\Backgrounds\UpdateBackgroundRequest;
use App\Services\Backgrounds\BackgroundService;
use Illuminate\Http\Request;

class BackgroundController extends Controller
{
    public function __construct(
        protected BackgroundService $service
    ) {
    }


    public function index()
    {
        $backgrounds =
            $this->service
                ->getAll();

        return view(
            'dashboard.backgrounds.index',
            compact('backgrounds')
        );
    }


    public function create()
    {
        return view(
            'dashboard.backgrounds.add'
        );
    }


    public function store(
        StoreBackgroundRequest $request
    ) {
        $this->service
            ->create(
                $request->validated()
            );


        return redirect()
            ->route(
                'admin.backgrounds.index'
            )
            ->with(
                'success',
                'Background berhasil ditambahkan.'
            );
    }


    public function edit(
        int $id
    ) {
        $background =
            $this->service
                ->findById($id);


        return view(
            'dashboard.backgrounds.edit',
            compact('background')
        );
    }


    public function update(
        UpdateBackgroundRequest $request,
        int $id
    ) {
        $background =
            $this->service
                ->findById($id);


        $this->service
            ->update(
                $background,
                $request->validated()
            );


        return redirect()
            ->route(
                'admin.backgrounds.index'
            )
            ->with(
                'success',
                'Background berhasil diperbarui.'
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


        $this->service
            ->updateStatus(
                $id,
                $validated['status']
            );


        return back()->with(
            'success',
            'Status background berhasil diperbarui.'
        );
    }


    public function destroy(
        int $id
    ) {
        $background =
            $this->service
                ->findById($id);


        $this->service
            ->delete(
                $background
            );


        return redirect()
            ->route(
                'admin.backgrounds.index'
            )
            ->with(
                'success',
                'Background berhasil dihapus.'
            );
    }
}
