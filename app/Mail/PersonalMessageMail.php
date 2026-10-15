<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PersonalMessageMail extends Mailable
{
    public $userMessage;
    public $adminMessage;

    public function __construct($messageData, $adminMessage)
    {
        $this->userMessage = $messageData->message;
        $this->adminMessage = $adminMessage;
    }

    public function build()
    {
        return $this->subject('Reply from Admin Travel Murah Jogja')
                    ->view('emails.chat');
    }
}
