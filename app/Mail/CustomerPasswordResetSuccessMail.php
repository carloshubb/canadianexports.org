<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class CustomerPasswordResetSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct($data)
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
            $subject = 'Your password has been reset successfully';
            $service = app(EmailTemplateService::class);
            $rendered = $service->render('customer_password_reset_success', ['data' => $this->data], $subject, null);

            if (!empty($rendered['body_html'])) {
                return $this->markdown('mails.dynamic-markdown')
                    ->subject($rendered['subject'] ?: $subject)
                    ->with([
                        'body_html' => $rendered['body_html'],
                        'data' => ['data' => $this->data],
                    ]);
            }

            return $this->markdown('mails/customer_password_reset_success')
                ->subject($subject)
                ->with("data", $this->data);
    }
}
