<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use Illuminate\Support\Facades\Log;

class CustomerVerifyEmailMail extends Mailable
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
    // public function build()
    // {
    //     return $this->markdown('mails/customer-verify-email')
    //         ->subject("Verify your email address. Complete your registration")
    //         ->with("data", $this->data);
    // }
    public function build()
    {
        if (($this->data['signup_page'] ?? null) === 'event') {
            $defaultSubject = 'Please verify your email to complete your event listing.';
        } else {
            $defaultSubject = 'Please verify your email to complete your exporter profile listing';
        }

        $service = app(EmailTemplateService::class);
        $rendered = $service->render('customer_verify_email', $this->data, $defaultSubject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $defaultSubject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $this->data,
                ]);
        }

        return $this->markdown('mails/customer-verify-email')
            ->subject($defaultSubject)
            ->with("data", $this->data);
    }
}
