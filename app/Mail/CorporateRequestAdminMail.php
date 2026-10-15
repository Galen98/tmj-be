<?php

namespace App\Mail;

use App\Models\CorporateRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorporateRequestAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $corporateRequest;

    public function __construct(
        CorporateRequest $corporateRequest
    ) {
        $this->corporateRequest =
            $corporateRequest;
    }

    public function build()
    {
        return $this
            ->subject(
                'Pengajuan Paket Korporasi Baru - ' .
                $this->corporateRequest->company_name
            )
            ->view(
                'emails.corporate-request-admin'
            );
    }
}
