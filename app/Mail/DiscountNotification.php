<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiscountNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $productName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productName)
    {
        $this->productName = $productName;
    }
    public function build()
    {
        return $this->subject('Discount')
            ->view('emails.discount_notification');
    }
}
