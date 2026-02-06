<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContentSubmittedBySponsorMail extends Mailable
{
    use Queueable, SerializesModels;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Content submitted by a Sponsor')
            ->markdown('mails.content-submitted-by-sponsor')
            ->with('data', $this->data);
    }
}
