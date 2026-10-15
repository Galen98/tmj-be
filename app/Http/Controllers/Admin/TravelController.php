<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTravelRequest;
use App\Http\Requests\Admin\UpdateTravelRequest;
use App\Models\City;
use App\Models\PointOfInterest;
use App\Models\Tag;
use App\Models\Travel;
use App\Services\Travel\TravelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function __construct(
        private TravelService $travelService
    ) {
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $corporate = $request->query('corporate', '');

        $travels = Travel::query()
            ->with(['city', 'pointOfInterest'])
            ->withCount('options')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('travel_name', 'like', '%' . $search . '%');
            })
            ->when(
                in_array($corporate, ['0', '1'], true),
                function ($query) use ($corporate) {
                    $query->where('is_corporate', (int) $corporate);
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.travels.index', compact('travels'));
    }

    public function create(): View
    {
        return view(
            'dashboard.travels.create',
            $this->getFormData()
        );
    }

    public function store(
        StoreTravelRequest $request
    ): RedirectResponse {
        $this->travelService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.travels.index')
            ->with(
                'success',
                'Paket wisata berhasil ditambahkan.'
            );
    }

    public function show(
        Travel $travel
    ): View {
        $travel = $this->travelService
            ->getDetail($travel);

        return view(
            'dashboard.travels.show',
            compact('travel')
        );
    }

    public function edit(
        Travel $travel
    ): View {
        $travel = $this->travelService
            ->getDetail($travel);

        return view(
            'dashboard.travels.edit',
            array_merge(
                ['travel' => $travel],
                $this->getFormData()
            )
        );
    }

    public function update(
        UpdateTravelRequest $request,
        Travel $travel
    ): RedirectResponse {
        $this->travelService->update(
            $travel,
            $request->validated()
        );

        return redirect()
            ->route('admin.travels.index')
            ->with(
                'success',
                'Paket wisata berhasil diperbarui.'
            );
    }

    public function destroy(
        Travel $travel
    ): RedirectResponse {
        $this->travelService->delete($travel);

        return redirect()
            ->route('admin.travels.index')
            ->with(
                'success',
                'Paket wisata berhasil dihapus.'
            );
    }

    private function getFormData(): array
    {
        return [
            'cities' => City::query()
                ->where('status', true)
                ->orderBy('name')
                ->get(),

            'pointOfInterests' => PointOfInterest::query()
                ->where('status', true)
                ->orderBy('name')
                ->get(),

            'tags' => Tag::query()
                ->where('status', true)
                ->orderBy('name')
                ->get(),
        ];
    }
}
