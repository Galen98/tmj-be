<?php

namespace App\Jobs;

use App\Mail\ContactUsReceivedMail;
use App\Models\ContactUs;
use App\Services\Mail\MailConfigurationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendContactUsReceivedEmail implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;


    public int $tries = 3;

    public int $timeout = 60;


    public function __construct(
        public int $contactId
    ) {
    }


    public function handle(
        MailConfigurationService $mailConfigurationService
    ): void {

        /*
         * =========================================
         * GET CONTACT
         * =========================================
         */

        $contact =
            ContactUs::findOrFail(
                $this->contactId
            );


        /*
         * =========================================
         * MAIL CONFIGURATION
         * =========================================
         *
         * Panggil method MailConfigurationService
         * yang SAMA seperti job subscription.
         *
         * Contoh:
         *
         * $mailConfigurationService->apply();
         *
         * Jangan pakai configure() kalau method
         * tersebut memang tidak ada.
         */


        /*
         * =========================================
         * SEND EMAIL
         * =========================================
         */

        Mail::to(
            $contact->email
        )->send(
            new ContactUsReceivedMail(
                $contact
            )
        );
    }


    public function failed(
        Throwable $exception
    ): void {

        logger()->error(
            'SendContactUsReceivedEmail failed',
            [
                'contactId' =>
                    $this->contactId,

                'error' =>
                    $exception->getMessage(),
            ]
        );
    }
}
