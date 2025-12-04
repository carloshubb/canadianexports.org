<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use App\Traits\HasUnsubscribeLink;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels, HasUnsubscribeLink;
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
        $subject = "Welcome to Canadian Exports";
        $service = app(EmailTemplateService::class);
        $rendered = $service->render('customer_welcome', ['data' => $this->data], $subject, null);

        // Generate unsubscribe link for customer email
        $recipientEmail = $this->data['email'] ?? null;
        if ($recipientEmail) {
            $this->withUnsubscribeLink($recipientEmail, 'customer');
        }

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => ['data' => $this->data],
                    'unsubscribeLink' => $this->unsubscribeLink,
                ]);
        }

        return $this->markdown('mails/customer-welcome')
            ->subject($subject)
            ->with([
                "data" => $this->data,
                "unsubscribeLink" => $this->unsubscribeLink,
            ]);
    }
}
