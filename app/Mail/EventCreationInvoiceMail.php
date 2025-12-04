<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class EventCreationInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data = [];
    private $email_to = null;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct($data, $email_to)
    {
        $this->data = $data;
        $this->email_to = $email_to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Event creation invoice';
        if ($this->email_to == 'admin') {
            $subject = 'Thank you for registering your event. Your invoice';
        }
        elseif ($this->email_to == 'customer') {
            $subject = 'Your Event Registration Details';
        }

        $service = app(EmailTemplateService::class);
        $payload = ['data' => $this->data, 'email_to' => $this->email_to];
        $rendered = $service->render('event_creation_invoice', $payload, $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $payload,
                ]);
        }

        return $this->markdown('mails/event-creation-invoice')
            ->subject($subject)
            ->with($payload);
    }
}
