<?php

namespace App\Mail;

use App\Models\Webinar;
use App\Models\WebinarRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WebinarReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $webinar;
    public $registration;
    public $reminderType; // '1_day' or '1_hour'

    public function __construct(Webinar $webinar, WebinarRegistration $registration, string $reminderType = '1_day')
    {
        $this->webinar = $webinar;
        $this->registration = $registration;
        $this->reminderType = $reminderType;
    }

    public function envelope(): Envelope
    {
        $timeText = $this->reminderType === '1_hour' ? 'Starting in 1 Hour' : 'Tomorrow';
        
        return new Envelope(
            subject: "Reminder: {$this->webinar->title} - {$timeText}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.webinar.reminder',
        );
    }
}

