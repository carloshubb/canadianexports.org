<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class NewCustomerAdminMail extends Mailable
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

    // public function build()
    // {
    //     return $this->markdown('mails/new-customer-admin')
    //         ->subject("New EXPORTER PROFILE registration on Canadian Exports")
    //         ->with("data", $this->data);
    // }

    // public function build()
    // {
    //     // Default subject for exporter profile
    //     $subject = "New EXPORTER PROFILE registration on Canadian Exports";

    //     // Check if registration is for an event
    //     if (isset($this->data['signup_page']) && $this->data['signup_page'] == 'event') {
    //         $subject = "New EVENT registration on Canadian Exports website";
    //     }

    //     return $this->markdown('mails/new-customer-admin')
    //         ->subject($subject)
    //         ->with("data", $this->data);
    // }

    public function build()
{
    $defaultData = [
        'company_name' => $this->data['company_name'] ?? 'Unnamed Event',
        'email' => $this->data['email'] ?? '',
        'contact_person_name' => $this->data['contact_person_name'] ?? '',
        'event_slug' => $this->data['event_slug'] ?? '',
        'package_type' => $this->data['package_type'] ?? 'Free',
        'package_price' => $this->data['package_price'] ?? 0,
        'created_at' => $this->data['created_at'] ?? now(),
        'end_date' => $this->data['end_date'] ?? now(),
    ];
    $service = app(EmailTemplateService::class);

    if (isset($this->data['signup_page']) && $this->data['signup_page'] == 'event') {
        $subject = "New EVENT registration on Canadian Exports website";
        $rendered = $service->render('event_registration', $defaultData, $subject, null);
        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $defaultData,
                ]);
        }
        return $this->markdown('mails.event-registration')
            ->subject($subject)
            ->with($defaultData);
    }

    $subject = "New EXPORTER PROFILE registration on Canadian Exports";
    $rendered = $service->render('new_customer_admin', ['data' => $this->data] + $defaultData, $subject, null);
    if (!empty($rendered['body_html'])) {
        return $this->markdown('mails.dynamic-markdown')
            ->subject($rendered['subject'] ?: $subject)
            ->with([
                'body_html' => $rendered['body_html'],
                'data' => ['data' => $this->data] + $defaultData,
            ]);
    }

    return $this->markdown('mails.new-customer-admin')
        ->subject($subject)
        ->with(['data' => $this->data]);
}

}
