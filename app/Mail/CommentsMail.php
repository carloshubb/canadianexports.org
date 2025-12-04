<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\EmailTemplateService;

class CommentsMail extends Mailable
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
    //     return $this->markdown('mails/comments')
    //         ->subject('New comments / suggestions form submission')
    //         ->with('data', $this->data);
    // }

    public function build()
{
    $subject = 'Thank you for your comments / suggestions';
    $service = app(EmailTemplateService::class);
    $rendered = $service->render('comments', ['data' => $this->data], $subject, null);

    if (!empty($rendered['body_html'])) {
        return $this->markdown('mails.dynamic-markdown')
            ->subject($rendered['subject'] ?: $subject)
            ->with([
                'body_html' => $rendered['body_html'],
                'data' => ['data' => $this->data],
            ]);
    }

    return $this->markdown('mails.comments')
        ->subject($subject)
        ->with('data', $this->data);
}
}
