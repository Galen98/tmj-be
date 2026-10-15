<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CorporateRequest;

class CorporateRequestController extends Controller
{
    public function index()
    {
        $corporateRequests =
            CorporateRequest::latest()
                ->paginate(10);

        return view(
            'dashboard.corporate-requests.index',
            compact('corporateRequests')
        );
    }


    public function show(
        CorporateRequest $corporateRequest
    ) {
        return view(
            'dashboard.corporate-requests.show',
            compact('corporateRequest')
        );
    }
}
