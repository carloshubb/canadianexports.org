<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;

class VisitorInfoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stats;
    public $statsSummary;

    public function __construct($stats, $statsSummary)
    {
        $this->stats = $stats;
        $this->statsSummary = $statsSummary;
    }

    public function build()
    {
        $subject = 'Visitor Stats Summary for ';
        $service = app(EmailTemplateService::class);
        $payload = ['stats' => $this->stats, 'statsSummary' => $this->statsSummary];
        $rendered = $service->render('visitor_info', $payload, $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $payload,
                ]);
        }

        return $this->markdown('mails.visitor_info')
            ->subject($subject);
    }
}
