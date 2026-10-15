<?php

namespace App\Jobs;

use App\Mail\SubscriptionWelcomeMail;
use App\Services\Mail\MailConfigurationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendSubscriptionWelcomeEmail implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $tries = 3;

    public int $timeout = 60;


    public function __construct(
        public string $email
    ) {
    }


    public function handle(
        MailConfigurationService $mailConfiguration
    ): void {

        /*
         * Ambil konfigurasi SMTP terbaru
         * dari parameter_globals.
         */

        $mailConfiguration->apply();


        /*
         * Kirim email.
         */

        Mail::to(
            $this->email
        )->send(
            new SubscriptionWelcomeMail()
        );
    }


    public function failed(
        ?Throwable $exception
    ): void {
        //
    }
}