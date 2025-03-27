<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Events\OrderPlaced;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Events\InvoiceGenerated;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty');
            }

            // Generate unique invoice number
            $invoiceNo = 'INV-' . time() . '-' . $userId;

            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'invoice_no' => $invoiceNo,
                'payment_status' => 'pending',
                'delivery_status' => 'processing',
                'order_status' => 'confirmed'
            ]);

            // Attach products to the order with their quantities and prices
            foreach ($cartItems as $cartItem) {
                $order->products()->attach($cartItem->product_id, [
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price
                ]);
            }

            // Clear the cart after successful order creation
            Cart::where('user_id', $userId)->delete();

            // Dispatch the OrderPlaced event
            event(new OrderPlaced($order));

            // Generate and send invoice
            $pdf = Pdf::loadView('pdf.invoice', compact('order'))->output();
            event(new InvoiceGenerated($order, $pdf));

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to confirm order: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }
    public function placeOrder(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'invoice_no' => 'INV-' . time() . '-' . Auth::id(),
            'payment_status' => 'pending',
            'delivery_status' => 'processing',
            'order_status' => 'confirmed'
        ]); // Order placement logic

        event(new OrderPlaced($order));

        return response()->json(['message' => 'Order placed successfully.']);
    }
    public function sendInvoice($orderId)
    {
        $order = Order::find($orderId);

        $pdf = Pdf::loadView('pdf.invoice', compact('order'))->output();

        event(new InvoiceGenerated($order, $pdf));

        return response()->json(['message' => 'Invoice sent successfully.']);
    }
}
