<?php
// In app/Mail/FinancingProgramListMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class FinancingProgramListMail extends Mailable
{
    use Queueable, SerializesModels;

    public $financingPrograms;

    public function __construct($financingPrograms)
    {
        $this->financingPrograms = $financingPrograms;
    }

    public function build()
    {
        $subject = 'Financing programs for your business';
        $service = app(EmailTemplateService::class);
        $payload = [
            'financingPrograms' => $this->financingPrograms
        ];
        $rendered = $service->render('financing_programs_list', $payload, $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $payload,
                ]);
        }

        return $this->markdown('mails/financing-programs-list')
            ->subject($subject)
            ->with($payload);
    }
}
