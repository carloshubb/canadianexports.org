<?php

namespace App\Mail;

use App\Models\Sponsor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SponsorContactRequestNotification extends Mailable
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
        $subject = 'Sponsor Contact Request - ' . $this->sponsor->business_name;
        $service = app(EmailTemplateService::class);
        $payload = ['sponsor' => $this->sponsor, 'data' => $this->data];
        $rendered = $service->render('sponsor_contact_request_notification', $payload, $subject, null);

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
            ->view('mails.sponsor-contact-request-notification')
            ->with([
                'sponsor' => $this->sponsor,
                'data' => $this->data
            ]);
    }
}
