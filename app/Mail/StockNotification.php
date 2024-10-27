<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jenis;
    public $productName;
    public $jumlah;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jenis, $productName, $jumlah)
    {
        $this->jenis = $jenis;
        $this->productName = $productName;
        $this->jumlah = $jumlah;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Stok Update')
            ->view('emails.stock_notification');
    }
}
