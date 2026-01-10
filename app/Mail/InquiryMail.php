<?php

namespace App\Mail;

use App\Models\I2b;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Attachment;
use App\Services\EmailTemplateService;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data = [];

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     $i2b = I2b::whereId($this->data['inquiry_id'])->first();
    //     $mail = $this->markdown('mails/inquiry')
    //         ->subject('Your “Inquiry to buy” from Canadian Exports')
    //         ->with('data', $this->data);
    //     if (isset($i2b['pdf_1']) && file_exists(public_path($i2b['pdf_1']))) {
    //         $mail->attach(public_path($i2b['pdf_1']));
    //     }
    //     if (isset($i2b['pdf_2']) && file_exists(public_path($i2b['pdf_2']))) {
    //         $mail->attach(public_path($i2b['pdf_2']));
    //     }
    //     return $mail;
    // }
//     public function build()
// {
//     $i2b = I2b::whereId($this->data['inquiry_id'])->first();
//     $mail = $this->markdown('mails/inquiry')
//         ->subject('Here are the Inquiries to buy details you asked for')
//         ->with('data', $this->data);
//     if (isset($i2b['pdf_1']) && file_exists(public_path($i2b['pdf_1']))) {
//         $mail->attach(public_path($i2b['pdf_1']));
//     }
//     if (isset($i2b['pdf_2']) && file_exists(public_path($i2b['pdf_2']))) {
//         $mail->attach(public_path($i2b['pdf_2']));
//     }
//     return $mail;
// }

public function build()
{
    // Ensure inquiry_id exists
    if (!isset($this->data['inquiry_id']) || empty($this->data['inquiry_id'])) {
        throw new \Exception('Inquiry ID is missing from email data');
    }
    
    $i2b = I2b::with(['i2bDetail', 'businessCategory'])->whereId($this->data['inquiry_id'])->first();
    
    if (!$i2b) {
        throw new \Exception('Inquiry not found');
    }

    // Safely get name with multiple fallbacks
    $userName = 'User';
    if (isset($this->data['name']) && !empty($this->data['name'])) {
        $userName = $this->data['name'];
    } elseif (isset($this->data['company_name']) && !empty($this->data['company_name'])) {
        $userName = $this->data['company_name'];
    } elseif (isset($this->data['company_email']) && !empty($this->data['company_email'])) {
        $userName = $this->data['company_email'];
    }

    $data = [
        'name' => $userName,
        'business_category' => $i2b->businessCategory && $i2b->businessCategory->businessCategoryDetail ? $i2b->businessCategory->businessCategoryDetail->first()->name ?? 'N/A' : 'N/A',
        'deadline_date' => !empty($i2b->deadline_date)
        ? Carbon::parse($i2b->deadline_date)->format('F d, Y')
        : 'N/A',
        'estimated_value' => $i2b->estimated_value ?? 'N/A',
        'inquiry_details' => $i2b->i2bDetail ? $i2b->i2bDetail->map(function ($detail) {
            return [
                'name' => $detail->name ?? 'N/A',
                'country' => $detail->country_name ?? 'N/A'
            ];
        })->toArray() : [],
        // Include PDF download links if available
        'pdf_download_links' => $this->data['pdf_download_links'] ?? [],
    ];

    $subject = 'Here are the Inquiries to buy details you asked for';
    $service = app(EmailTemplateService::class);
    
    // Pass data directly (not nested) so EmailTemplateService can merge it correctly
    // The service will create both $data array and individual variables
    $rendered = $service->render('inquiry', $data, $subject, null);

    if (!empty($rendered['body_html'])) {
        $mail = $this->markdown('mails.dynamic-markdown')
            ->subject($rendered['subject'] ?: $subject)
            ->with([
                'body_html' => $rendered['body_html'],
                'data' => $data, // Pass data directly, not nested
            ]);
    } else {
        $mail = $this->view('mails.inquiry')
            ->subject($subject)
            ->with('data', $data);
    }

    // PDFs are now sent as secure download links in the email template, not as attachments
    // This prevents email size issues and provides better security

    return $mail;
}



}
