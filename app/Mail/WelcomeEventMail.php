<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailTemplateService;

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
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Welcome to Canadian Exports. Your event is live!";
        $service = app(EmailTemplateService::class);
        $rendered = $service->render('welcome_event_user', ['data' => $this->data], $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => ['data' => $this->data],
                ]);
        }

        return $this->markdown('mails/welcome-event-user')
            ->subject($subject)
            ->with("data", $this->data);
    }
}
