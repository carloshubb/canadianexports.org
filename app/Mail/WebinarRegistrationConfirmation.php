<?php

namespace App\Mail;

use App\Models\Webinar;
use App\Models\WebinarRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WebinarRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $webinar;
    public $registration;

    public function __construct(Webinar $webinar, WebinarRegistration $registration)
    {
        $this->webinar = $webinar;
        $this->registration = $registration;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Confirmed: ' . $this->webinar->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.webinar.registration-confirmation',
        );
    }
}

