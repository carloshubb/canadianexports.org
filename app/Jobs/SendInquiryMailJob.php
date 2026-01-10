<?php

namespace App\Jobs;

use App\Mail\InquiryMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInquiryMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $toEmail;
    protected $adminEmails;

    public function __construct($data, $toEmail, $adminEmails)
    {
        $this->data = $data;
        $this->toEmail = $toEmail;
        $this->adminEmails = $adminEmails;
    }

    public function handle()
    {
        $mail = new InquiryMail($this->data);

        // PDFs are now sent as download links in the email template, not as attachments
        // This prevents email size issues and provides better security

        Mail::to($this->toEmail)->cc($this->adminEmails)->send($mail);
    }
}
