<?php

namespace App\Mail;

use App\Models\ContactUs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactUs $contact
    ) {
    }

    public function build()
    {
        return $this
            ->subject(
                'Terima Kasih Telah Menghubungi Travel Murah Jogja'
            )
            ->view(
                'emails.contact-us.received'
            );
    }
}
