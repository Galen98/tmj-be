<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailCustomer;
use App\Services\EmailCustomers\EmailCustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailCustomerController extends Controller
{
    public function __construct(
        private EmailCustomerService $service
    ) {
    }


    public function index(
        Request $request
    ): View {

        $customers =
            $this->service
                ->getPaginated(
                    $request->get('search')
                );


        return view(
            'dashboard.email-customers.index',
            compact('customers')
        );
    }


    public function updateStatus(
        Request $request,
        EmailCustomer $emailCustomer
    ): RedirectResponse {

        $validated =
            $request->validate([
                'status' => [
                    'required',
                    'boolean',
                ],
            ]);


        $this->service
            ->updateStatus(
                $emailCustomer,
                (bool) $validated['status']
            );


        return back()->with(
            'success',
            'Status email customer berhasil diperbarui.'
        );
    }
}