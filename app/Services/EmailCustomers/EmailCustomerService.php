<?php

namespace App\Services\EmailCustomers;

use App\DTO\EmailCustomers\EmailCustomerDTO;
use App\Jobs\SendSubscriptionWelcomeEmail;
use App\Models\EmailCustomer;
use App\Repositories\EmailCustomers\EmailCustomerRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class EmailCustomerService
{
    /*
     * =========================================
     * CONSTRUCTOR
     * =========================================
     */

    public function __construct(
        private EmailCustomerRepository $repository
    ) {
    }


    /*
     * =========================================
     * SUBSCRIBE
     * =========================================
     */

    public function subscribe(
        EmailCustomerDTO $dto
    ): array {

        /*
         * =========================================
         * CHECK EXISTING EMAIL
         * =========================================
         */

        $existing =
            $this->repository
                ->findByEmail(
                    $dto->getEmail()
                );


        /*
         * =========================================
         * EMAIL SUDAH ADA
         * =========================================
         */

        if ($existing) {

            /*
             * Kalau sebelumnya sudah pernah
             * subscribe tetapi statusnya nonaktif,
             * aktifkan kembali.
             */

            if (!$existing->status) {

                $existing =
                    $this->repository
                        ->updateStatus(
                            $existing,
                            true
                        );


                /*
                 * Masukkan welcome email
                 * ke queue lagi karena customer
                 * melakukan subscribe ulang.
                 */

                SendSubscriptionWelcomeEmail::dispatch(
                    $existing->email
                );


                return [
                    'alreadySubscribed' => false,
                    'customer' => $existing,
                ];
            }


            /*
             * Email sudah terdaftar dan
             * status masih aktif.
             *
             * Tidak perlu kirim welcome email lagi.
             */

            return [
                'alreadySubscribed' => true,
                'customer' => $existing,
            ];
        }


        /*
         * =========================================
         * CREATE NEW CUSTOMER
         * =========================================
         */

        $customer =
            $this->repository
                ->create([
                    'email' =>
                        $dto->getEmail(),

                    'status' =>
                        true,

                    'subscribed_at' =>
                        now(),
                ]);


        /*
         * =========================================
         * DISPATCH WELCOME EMAIL
         * =========================================
         *
         * Email tidak dikirim langsung di sini.
         *
         * Job dimasukkan ke database queue,
         * kemudian diproses oleh queue:work.
         */

        SendSubscriptionWelcomeEmail::dispatch(
            $customer->email
        );


        /*
         * =========================================
         * RESPONSE
         * =========================================
         */

        return [
            'alreadySubscribed' => false,
            'customer' => $customer,
        ];
    }


    /*
     * =========================================
     * GET PAGINATED
     * =========================================
     *
     * Digunakan halaman admin Email Customer.
     */

    public function getPaginated(
        ?string $search = null
    ): LengthAwarePaginator {

        return $this->repository
            ->getPaginated(
                $search
            );
    }


    /*
     * =========================================
     * UPDATE STATUS
     * =========================================
     */

    public function updateStatus(
        EmailCustomer $customer,
        bool $status
    ): EmailCustomer {

        return $this->repository
            ->updateStatus(
                $customer,
                $status
            );
    }
}