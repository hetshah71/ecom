<?php

namespace App\Listeners;

use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Events\OrderPlaced;

class SendOrderPlacedEmail
{
    public function handle(OrderPlaced $event)
    {
        try {
            // Send email to the user
            Mail::to($event->order->user->email)->queue(new OrderPlacedMail($event->order));

            // Send email to the admin
            Mail::to('admin@example.com')->queue(new OrderPlacedMail($event->order));

            Log::info('Order placed emails sent successfully.', ['order_id' => $event->order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order placed email.', [
                'order_id' => $event->order->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
