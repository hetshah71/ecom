<?php

namespace App\Listeners;

use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmail
{
    public function handle($event)
    {
        Mail::to($event->order->user->email)->queue(new InvoiceMail($event->order, $event->pdf));
    }
}
