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

        if (!empty($this->data['pdf_1']) && file_exists(public_path($this->data['pdf_1']))) {
            $mail->attach(public_path($this->data['pdf_1']));
        }

        if (!empty($this->data['pdf_2']) && file_exists(public_path($this->data['pdf_2']))) {
            $mail->attach(public_path($this->data['pdf_2']));
        }

        if (!empty($this->data['pdf_3']) && file_exists(public_path($this->data['pdf_3']))) {
            $mail->attach(public_path($this->data['pdf_3']));
        }

        Mail::to($this->toEmail)->cc($this->adminEmails)->send($mail);
    }
}
