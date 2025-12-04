<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerResetPasswordMail extends Mailable
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
    //     return $this->markdown('mails/customer-reset-password')
    //         ->subject('Reset your password')
    //         ->with("data", $this->data);
    // }
    public function build()
{
    $subject = 'Reset your password';
    $service = app(EmailTemplateService::class);
    $rendered = $service->render('customer_reset_password', ['data' => $this->data], $subject, null);

    if (!empty($rendered['body_html'])) {
        return $this->markdown('mails.dynamic-markdown')
            ->subject($rendered['subject'] ?: $subject)
            ->with([
                'body_html' => $rendered['body_html'],
                'data' => ['data' => $this->data],
            ]);
    }

    return $this->markdown('mails.customer-reset-password')
        ->subject($subject)
        ->with("data", $this->data);
}
}
