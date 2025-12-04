<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class AdminMembershipExpiryMail extends Mailable
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
        $customerName = $this->data['customer']['name'];
        $subject = $customerName . "'s package expiration reminder";
        $service = app(EmailTemplateService::class);
        $rendered = $service->render('admin_membership_expiry', ['data' => $this->data], $subject, null);

        if (!empty($rendered['body_html'])) {
            return $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: $subject)
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => ['data' => $this->data],
                ]);
        }

        return $this->markdown('mails/admin-membership-expiry')
            ->subject($subject)
            ->with("data", $this->data);
    }
}
