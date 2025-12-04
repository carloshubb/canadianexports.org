<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use Illuminate\Contracts\Queue\ShouldQueue;

class InfoLetterSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $subject = 'Welcome to Canadian Exports';
        $service = app(EmailTemplateService::class);
        $rendered = $service->render('info_letter_response', ['data' => $this->data], $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => ['data' => $this->data],
                ]);
        }

        return $this->markdown('mails.info-letter-response')
            ->subject($subject)
            ->with('data', $this->data);
    }
}
