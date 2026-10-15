<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cities\StoreCityRequest;
use App\Http\Requests\Cities\UpdateCityRequest;
use App\Services\Cities\CityService;

class CityController extends Controller
{
    public function __construct(
        protected CityService $cityService
    ) {
    }

    public function index()
    {
        $cities =
            $this->cityService
                ->getAll();

        return view(
            'dashboard.cities.index',
            compact('cities')
        );
    }

    public function create()
    {
        return view(
            'dashboard.cities.add'
        );
    }

    public function store(
        StoreCityRequest $request
    ) {
        $this->cityService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.cities.index')
            ->with(
                'success',
                'City berhasil ditambahkan.'
            );
    }

    public function edit(
        int $id
    ) {
        $city =
            $this->cityService
                ->findById($id);

        return view(
            'dashboard.cities.edit',
            compact('city')
        );
    }

    public function update(
        UpdateCityRequest $request,
        int $id
    ) {
        $city =
            $this->cityService
                ->findById($id);

        $this->cityService->update(
            $city,
            $request->validated()
        );

        return redirect()
            ->route('admin.cities.index')
            ->with(
                'success',
                'City berhasil diperbarui.'
            );
    }

    public function destroy(
        int $id
    ) {
        $city =
            $this->cityService
                ->findById($id);

        $this->cityService->delete(
            $city
        );

        return redirect()
            ->route('admin.cities.index')
            ->with(
                'success',
                'City berhasil dihapus.'
            );
    }
}
