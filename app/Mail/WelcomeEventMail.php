<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WelcomeEventMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = array_merge([
            'event_name' => null,
            'package_name' => null,
            'package_price' => 0,
        ], $data);
    }

    /**
     * Build the message.
     * Always use welcome-event-user view to avoid "Undefined array key event_name"
     * when DB template (dynamic-markdown path) expects different $data structure.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Welcome to Canadian Exports. Your event is live!";

        return $this->markdown('mails/welcome-event-user')
            ->subject($subject)
            ->with('data', $this->data);
    }
}
