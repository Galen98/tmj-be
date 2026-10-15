<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vouchers\StoreVoucherRequest;
use App\Http\Requests\Vouchers\UpdateVoucherRequest;
use App\Services\Vouchers\VoucherService;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherService $service
    ) {
    }


    public function index()
    {
        $vouchers =
            $this->service
                ->getAll();

        return view(
            'dashboard.vouchers.index',
            compact('vouchers')
        );
    }


    public function create()
    {
        return view(
            'dashboard.vouchers.add'
        );
    }


    public function store(
        StoreVoucherRequest $request
    ) {
        $this->service
            ->create(
                $request->validated()
            );

        return redirect()
            ->route(
                'admin.vouchers.index'
            )
            ->with(
                'success',
                'Voucher berhasil ditambahkan.'
            );
    }


    public function edit(
        int $id
    ) {
        $voucher =
            $this->service
                ->findById($id);

        return view(
            'dashboard.vouchers.edit',
            compact('voucher')
        );
    }


    public function update(
        UpdateVoucherRequest $request,
        int $id
    ) {
        $voucher =
            $this->service
                ->findById($id);

        $this->service
            ->update(
                $voucher,
                $request->validated()
            );

        return redirect()
            ->route(
                'admin.vouchers.index'
            )
            ->with(
                'success',
                'Voucher berhasil diperbarui.'
            );
    }


    public function destroy(
        int $id
    ) {
        $voucher =
            $this->service
                ->findById($id);

        $this->service
            ->delete($voucher);

        return redirect()
            ->route(
                'admin.vouchers.index'
            )
            ->with(
                'success',
                'Voucher berhasil dihapus.'
            );
    }
}
