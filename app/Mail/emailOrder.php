<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $namePdf = explode("@", $this->order['user']['email']);
        $datePdf = date("Ymd");
        return $this->markdown('emails.sendorder')->from('contacto@rollux.com.mx')->subject('Cotización de producto(s)')->attach('img/'.$namePdf[0].$datePdf.'.pdf');
    }


}
