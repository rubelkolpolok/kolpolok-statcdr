<?php

namespace App\Mail;

use App\Agmt_list;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AskedTradeReference extends Mailable
{
    use Queueable, SerializesModels;

    public $agreement;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Agmt_list $agmt_list)
    {
        $this->agreement = $agmt_list;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.agreements.reference');
    }
}
