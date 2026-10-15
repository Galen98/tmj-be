<?php

namespace App\Jobs;

use App\Mail\CorporateRequestAdminMail;
use App\Models\CorporateRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCorporateRequestAdminEmail
    implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    public $corporateRequestId;


    public function __construct(
        $corporateRequestId
    ) {
        $this->corporateRequestId =
            $corporateRequestId;
    }


    public function handle()
    {
        $corporateRequest =
            CorporateRequest::find(
                $this->corporateRequestId
            );

        if (!$corporateRequest) {
            return;
        }

        Mail::to(
            'herucod@gmail.com'
        )->send(
            new CorporateRequestAdminMail(
                $corporateRequest
            )
        );
    }
}
