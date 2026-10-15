<?php

namespace App\Repositories\EmailCustomers;

use App\Models\EmailCustomer;
use Illuminate\Pagination\LengthAwarePaginator;

class EmailCustomerRepository
{
    public function findByEmail(
        string $email
    ): ?EmailCustomer {

        return EmailCustomer::where(
            'email',
            $email
        )->first();
    }


    public function create(
        array $data
    ): EmailCustomer {

        return EmailCustomer::create(
            $data
        );
    }


    public function getPaginated(
        ?string $search = null
    ): LengthAwarePaginator {

        $query = EmailCustomer::query();

        if (!empty($search)) {
            $query->where(
                'email',
                'like',
                '%' . $search . '%'
            );
        }

        return $query
            ->latest('subscribed_at')
            ->paginate(20);
    }


    public function updateStatus(
        EmailCustomer $customer,
        bool $status
    ): EmailCustomer {

        $customer->update([
            'status' => $status,
        ]);


        return $customer->refresh();
    }
}