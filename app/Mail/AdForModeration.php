<?php

namespace App\Mail;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdForModeration extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * The order instance.
     *
     * @var Ad
     */
    public $ad;

    /**
     * Create a new message instance.
     *
     * @param Ad $ad
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): AdForModeration
    {
        return $this->view('moderator.emails.ad_for_moderation');
    }
}
