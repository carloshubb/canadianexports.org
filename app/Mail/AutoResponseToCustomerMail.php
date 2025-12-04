<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class AutoResponseToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

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
        $rendered = $service->render('auto_response_to_customer', $this->data, 'Your message has been received', null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: 'Your message has been received')
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $this->data,
                ]);
        }

        return $this->markdown('mails/auto-response-to-customer')
            ->subject('Your message has been received')
            ->with('data', $this->data);
    }
}
