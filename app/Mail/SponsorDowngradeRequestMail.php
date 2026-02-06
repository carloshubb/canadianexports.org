<?php

namespace App\Mail;

use App\Models\Sponsor;
use App\Models\SponsorDowngradeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorDowngradeRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsor;
    public $request;

    public function __construct(Sponsor $sponsor, SponsorDowngradeRequest $request)
    {
        $this->sponsor = $sponsor;
        $this->request = $request;
    }

    public function build()
    {
        return $this->subject('Sponsor downgrade requested on Canadian Exports')
            ->view('mails.sponsor-downgrade-request')
            ->with([
                'sponsor' => $this->sponsor,
                'request' => $this->request,
            ]);
    }
}
