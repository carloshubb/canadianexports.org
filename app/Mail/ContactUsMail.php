<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;
use App\Services\EmailSubscriptionService;
use App\Traits\HasUnsubscribeLink;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels, HasUnsubscribeLink;

    private $data = [];

    /**
     * Create a new message instance.
     *
     * @param array $data
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
        $service = app(EmailTemplateService::class);
        $rendered = $service->render('contact_us_admin', $this->data, 'New contact form submission', null);

        // Generate unsubscribe link if email is provided in data
        $recipientEmail = $this->data['email'] ?? null;
        if ($recipientEmail) {
            $this->withUnsubscribeLink($recipientEmail);
        }

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: 'New contact form submission')
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $this->data,
                    'unsubscribeLink' => $this->unsubscribeLink,
                ]);
        }

        return $this->markdown('mails/contact')
            ->subject('New contact form submission')
            ->with([
                'data' => $this->data,
                'unsubscribeLink' => $this->unsubscribeLink,
            ]);
    }
}
