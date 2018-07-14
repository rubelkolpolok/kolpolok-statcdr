<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TradeEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $reference;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.agreements.enquiry');
    }
}
