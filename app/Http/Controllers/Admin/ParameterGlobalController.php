<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParameterGlobal;
use App\Services\ParameterGlobals\ParameterGlobalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParameterGlobalController extends Controller
{
    public function __construct(
        private ParameterGlobalService $service
    ) {
    }


    public function index(): View
    {
        $parameters =
            $this->service
                ->getAll();

        return view(
            'dashboard.parameter-global.index',
            compact('parameters')
        );
    }


    public function update(
        Request $request,
        ParameterGlobal $parameterGlobal
    ): RedirectResponse {

        $validated =
            $request->validate([
                'value' => [
                    'nullable',
                    'string',
                ],
            ]);


        $this->service->update(
            $parameterGlobal,
            $validated['value'] ?? null
        );


        return back()->with(
            'success',
            'Parameter berhasil diperbarui.'
        );
    }
}
