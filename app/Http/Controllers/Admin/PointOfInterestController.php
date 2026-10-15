<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointOfInterests\StorePointOfInterestRequest;
use App\Http\Requests\PointOfInterests\UpdatePointOfInterestRequest;
use App\Services\Cities\CityService;
use App\Services\PointOfInterests\PointOfInterestService;

class PointOfInterestController extends Controller
{
    public function __construct(
        protected PointOfInterestService $pointOfInterestService,
        protected CityService $cityService
    ) {
    }

    public function index()
    {
        $pointOfInterests =
            $this->pointOfInterestService
                ->getAll();

        return view(
            'dashboard.point-of-interests.index',
            compact('pointOfInterests')
        );
    }

    public function create()
    {
        $cities =
            $this->cityService
                ->getAllActive();

        return view(
            'dashboard.point-of-interests.add',
            compact('cities')
        );
    }

    public function store(
        StorePointOfInterestRequest $request
    ) {
        $this->pointOfInterestService
            ->create(
                $request->validated()
            );

        return redirect()
            ->route(
                'admin.point-of-interests.index'
            )
            ->with(
                'success',
                'Point of Interest berhasil ditambahkan.'
            );
    }

    public function edit(
        int $id
    ) {
        $pointOfInterest =
            $this->pointOfInterestService
                ->findById($id);

        $cities =
            $this->cityService
                ->getAllActive();

        return view(
            'dashboard.point-of-interests.edit',
            compact(
                'pointOfInterest',
                'cities'
            )
        );
    }

    public function update(
        UpdatePointOfInterestRequest $request,
        int $id
    ) {
        $pointOfInterest =
            $this->pointOfInterestService
                ->findById($id);

        $this->pointOfInterestService
            ->update(
                $pointOfInterest,
                $request->validated()
            );

        return redirect()
            ->route(
                'admin.point-of-interests.index'
            )
            ->with(
                'success',
                'Point of Interest berhasil diperbarui.'
            );
    }

    public function destroy(
        int $id
    ) {
        $pointOfInterest =
            $this->pointOfInterestService
                ->findById($id);

        $this->pointOfInterestService
            ->delete(
                $pointOfInterest
            );

        return redirect()
            ->route(
                'admin.point-of-interests.index'
            )
            ->with(
                'success',
                'Point of Interest berhasil dihapus.'
            );
    }
}
