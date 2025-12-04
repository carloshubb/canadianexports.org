<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use Illuminate\Contracts\Queue\ShouldQueue;

class InfoLetterAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $file;
    public $unsubscribeLink;

    public function __construct($message, $file = null, $email = null)
    {
        $this->message = $message;
        $this->file = $file;

        // Generate unsubscribe link if email is provided
        if ($email) {
            $infoLetter = \App\Models\InfoLetter::where('email', $email)->first();
            if ($infoLetter) {
                $this->unsubscribeLink = route('front.confirm-unsubscribe', ['q' => $infoLetter->subscribe_hash]);
            }
        }
    }

    public function build()
    {
        $subject = 'Welcome to Canadian Exports';
        $service = app(EmailTemplateService::class);
        $payload = [
            'message' => $this->message,
            'unsubscribeLink' => $this->unsubscribeLink ?? null
        ];
        $rendered = $service->render('info_letter_admin', $payload, $subject, null);

        if (!empty($rendered['body_html'])) {
            $mail = $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $payload,
                ]);
        } else {
            $mail = $this->markdown('mails.info-letter-admin')
                ->subject($subject)
                ->with($payload);
        }

        if ($this->file) {
            $mail->attach($this->file->getRealPath(), [
                'as' => $this->file->getClientOriginalName(),
                'mime' => $this->file->getMimeType(),
            ]);
        }

        return $mail;
    }
}
