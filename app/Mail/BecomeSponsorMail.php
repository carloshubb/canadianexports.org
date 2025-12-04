<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class BecomeSponsorMail extends Mailable
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
    public function build()
    {
        $service = app(EmailTemplateService::class);
        $rendered = $service->render(
            'become_sponsor_admin',
            $this->data,
            'A user is interested in becoming a Sponsor on Canadian Exports website',
            null
        );

        $mail = null;
        
        // If database template found and rendered
        if (!empty($rendered['body_html'])) {
            $mail = $this->markdown('mails.dynamic-markdown')
                ->subject($rendered['subject'] ?: 'A user is interested in becoming a Sponsor on Canadian Exports website')
                ->with([
                    'body_html' => $rendered['body_html'],
                    'data' => $this->data,
                ]);
        } else {
            // Fallback to original Blade template
            $mail = $this->markdown('mails/become-sponsor')
                ->subject('A user is interested in becoming a Sponsor on Canadian Exports website')
                ->with('data', $this->data);
        }

        // Keep existing attachment logic
        if (isset($this->data['image'])) {
            $media = json_decode($this->data['image'], 1);
            if (is_array($media)) {
                foreach ($media as $key => $m) {
                    $path = storage_path('app/public') . '/' . $m;
                    $mail->attach($path);
                }
            }
        }
        if (isset($this->data['feature_image'])) {
            $media = json_decode($this->data['feature_image'], 1);
            if (is_array($media)) {
                foreach ($media as $key => $m) {
                    $path = storage_path('app/public') . '/' . $m;
                    $mail->attach($path);
                }
            }
        }
        
        return $mail;
    }
}
