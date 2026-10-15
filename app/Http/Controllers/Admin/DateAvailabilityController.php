<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DateAvailability;
use App\Models\Travel;
use App\Models\TravelOption;
use App\Services\DateAvailabilities\DateAvailabilityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DateAvailabilityController extends Controller
{
    public function __construct(
        private DateAvailabilityService $service
    ) {}

    public function index(Request $request): View
    {
        $travels = $this->service->getTravels(
            $request->query('search')
        );

        return view(
            'dashboard.date-availabilities.index',
            compact('travels')
        );
    }

    public function options(Travel $travel): View
    {
        $options = $this->service->getOptions($travel);

        return view(
            'dashboard.date-availabilities.options',
            compact('travel', 'options')
        );
    }

    public function manage(TravelOption $option): View
    {
        $option->load('travel');

        $availabilities = $this->service->getDates($option);

        return view(
            'dashboard.date-availabilities.manage',
            compact('option', 'availabilities')
        );
    }

    public function store(
        Request $request,
        TravelOption $option
    ): RedirectResponse {
        $this->service->create($option, $request->only([
            'date',
            'status',
        ]));

        return back()->with(
            'success',
            'Tanggal berhasil ditambahkan.'
        );
    }

    public function update(
        Request $request,
        DateAvailability $availability
    ): RedirectResponse {
        $this->service->update($availability, $request->only([
            'date',
            'status',
        ]));

        return back()->with(
            'success',
            'Tanggal berhasil diperbarui.'
        );
    }

    public function destroy(
        DateAvailability $availability
    ): RedirectResponse {
        $this->service->delete($availability);

        return back()->with(
            'success',
            'Tanggal berhasil dihapus.'
        );
    }
}
