<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class CustomerReactiveEmailMail extends Mailable
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
    //     return $this->markdown('mails/customer-reactive-email')
    //         ->subject("Reactivate Your Account on Canadian Exporters")
    //         ->with("data", $this->data);
    // }
    public function build()
{
    $subject = "Your account has been reactivated. Welcome back!";
    $service = app(EmailTemplateService::class);
    $rendered = $service->render('customer_reactive_email', ['data' => $this->data], $subject, null);

    if (!empty($rendered['body_html'])) {
        return $this->markdown('mails.dynamic-markdown')
            ->subject($rendered['subject'] ?: $subject)
            ->with([
                'body_html' => $rendered['body_html'],
                'data' => ['data' => $this->data],
            ]);
    }

    return $this->markdown('mails/customer-reactive-email')
        ->subject($subject)
        ->with("data", $this->data);
}
}
