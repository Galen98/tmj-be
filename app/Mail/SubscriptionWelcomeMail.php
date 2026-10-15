<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang di Travel Murah Jogja!'
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-welcome'
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
