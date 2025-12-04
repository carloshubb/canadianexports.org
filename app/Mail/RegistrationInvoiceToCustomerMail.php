<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailTemplateService;

class RegistrationInvoiceToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;
    
    private $data = [];
    /**
     * Create a new message instance.
     *
     * @return void
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
    public function build()
    {
        $pdf = null;
        if ($this->data['order']) {
            Log::info('public/invoices/registration-invoice/' . $this->data['order']['invoice_no'] . '.pdf');

            $pdf = Storage::get('public/invoices/registration-invoice/' . $this->data['order']['invoice_no'] . '.pdf');
        }

        $service = app(EmailTemplateService::class);
        $isEvent = ($this->data['customer']['type'] ?? null) === 'event';
        $subject = $isEvent
            ? "Thank you for registering your event. Your invoice "
            : "Thank you for registering with Canadian Exports. Your invoice ";

        $rendered = $service->render('registration_invoice', ['data' => $this->data], $subject, null);
        if (!empty($rendered['body_html'])) {
            $email = $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => ['data' => $this->data],
                ]);
        } else {
            $email = $this->markdown('mails/registration-invoice-to-customer')
                ->subject($subject)
                ->with("data", $this->data);
        }
        

        if (isset($pdf)) {
            $email->attachData($pdf, 'invoice.pdf');
        }

        return $email;
    }
}
