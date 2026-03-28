<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $data) {}

    public function build(): static
    {
        return $this
            ->subject('Ново запитване от ' . $this->data['name'])
            ->replyTo($this->data['email'])
            ->view('mail.inquiry');
    }
}
