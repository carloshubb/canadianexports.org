<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;
use App\Traits\HasUnsubscribeLink;

class HolidayMail extends Mailable
{
    use Queueable, SerializesModels, HasUnsubscribeLink;

    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;

        // Generate unsubscribe link using the new service
        $customerEmail = $data['customer']['email'] ?? null;
        if ($customerEmail) {
            $this->withUnsubscribeLink($customerEmail, 'customer');
        }
    }

    public function build()
    {
        $fallbackSubject = $this->data['holiday_email']['email_subject'] ?? 'Holiday Greetings';
        $service = app(EmailTemplateService::class);
        $payload = [
            "data" => $this->data,
            "unsubscribeLink" => $this->unsubscribeLink
        ];
        $rendered = $service->render('holiday_email', $payload, $fallbackSubject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $fallbackSubject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $payload,
                ]);
        }

        return $this->markdown('mails.holiday-email')
            ->subject($fallbackSubject)
            ->with($payload);
    }
}
