<?php

namespace App\Mail;

use App\Models\Sponsor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSponsorPaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsor;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sponsor $sponsor, $data = [])
    {
        $this->sponsor = $sponsor;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'New Sponsor Payment Received - ' . $this->sponsor->business_name;
        $service = app(EmailTemplateService::class);
        $payload = ['sponsor' => $this->sponsor, 'data' => $this->data];
        $rendered = $service->render('new_sponsor_payment_notification', $payload, $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'sponsor' => $this->sponsor,
                    'data' => $payload,
                ]);
        }

        return $this->subject($subject)
                    ->view('mails.new-sponsor-payment-notification')
                    ->with([
                        'sponsor' => $this->sponsor,
                        'data' => $this->data
                    ]);
    }
}

