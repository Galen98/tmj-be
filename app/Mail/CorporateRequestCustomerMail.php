<?php

namespace App\Mail;

use App\Models\CorporateRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorporateRequestCustomerMail extends Mailable
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
                'Permintaan Paket Korporasi Telah Kami Terima'
            )
            ->view(
                'emails.corporate-request-customer'
            );
    }
}
