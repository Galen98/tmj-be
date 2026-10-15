<?php

namespace App\Jobs;

use App\Mail\ContactUsReplyMail;
use App\Models\ContactUs;
use App\Models\ContactUsReply;
use App\Services\Mail\MailConfigurationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendContactUsReplyEmail implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;


    public int $tries = 3;

    public int $timeout = 60;


    public function __construct(
        public int $contactId,
        public int $replyId
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
         * GET REPLY
         * =========================================
         */

        $reply =
            ContactUsReply::findOrFail(
                $this->replyId
            );


        /*
         * =========================================
         * MAIL CONFIGURATION
         * =========================================
         *
         * Panggil method MailConfigurationService
         * yang sama dengan subscription job.
         */


        /*
         * =========================================
         * SEND EMAIL
         * =========================================
         */

        Mail::to(
            $contact->email
        )->send(
            new ContactUsReplyMail(
                $contact,
                $reply
            )
        );
    }


    public function failed(
        Throwable $exception
    ): void {

        logger()->error(
            'SendContactUsReplyEmail failed',
            [
                'contactId' =>
                    $this->contactId,

                'replyId' =>
                    $this->replyId,

                'error' =>
                    $exception->getMessage(),
            ]
        );
    }
}
