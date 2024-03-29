<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class BuyedOrderAdminNetpay extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
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
        return $this->markdown('emails.buyedorderadminnetpay')->from('contacto@rollux.com.mx')->subject('ADQUIRIDA - #ORDEN: '.$this->order->user->id.'P'.Carbon::parse($this->order->created_at)->format('dmy').$this->order->id);
    }
}
