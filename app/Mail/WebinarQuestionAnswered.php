<?php

namespace App\Mail;

use App\Models\Webinar;
use App\Models\WebinarQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WebinarQuestionAnswered extends Mailable
{
    use Queueable, SerializesModels;

    public $webinar;
    public $question;

    public function __construct(Webinar $webinar, WebinarQuestion $question)
    {
        $this->webinar = $webinar;
        $this->question = $question;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Question Was Answered: ' . $this->webinar->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.webinar.question-answered',
        );
    }
}

