<?php

// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Mail\Mailable;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Queue\ShouldQueue;

// class AdvertisterEmailToCustomerMail extends Mailable
// {
//     use Queueable, SerializesModels;
//     public $customerProfile;
//     public $data;

//     /**
//      * Build the message.
//      *
//      * @return $this
//      */
//     public function build()
//     {
//         // return $this->markdown('mails/advertister-email-to-customer')
//         //     ->subject('Your message has been delivered ');
//         return $this->markdown('mails/advertister-email-to-customer')
//         ->with([
//             'customerProfile' => $this->customerProfile,
//             'data' => $this->data,
//         ])
//         ->subject('Your message has been delivered');
//     }
// }

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\EmailTemplateService;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdvertisterEmailToCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customerProfile;
    public $data;

    /**
     * Create a new message instance.
     *
     * @param $customerProfile
     * @param $data
     */
    public function __construct($customerProfile, $data)
    {
        $this->customerProfile = $customerProfile;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your message has been delivered ';
        $service = app(EmailTemplateService::class);
        $payload = [
            'customerProfile' => $this->customerProfile,
            'data' => $this->data,
        ];
        $rendered = $service->render('advertister_email_to_customer', $payload, $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $payload,
                ]);
        }

        return $this->markdown('mails.advertister-email-to-customer')
            ->with($payload)
            ->subject($subject);
    }
}
