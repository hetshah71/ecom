<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function confirmOrder($cartItems, $address)
    {
        try {
            $userId = Auth::id();

            // Save shipping address
            $Address = Address::create([
                'user_id' => $userId,
                'address' => $address
            ]);


            // Eager load the products relationship (use the passed $cartItems if already loaded)
            if (!$cartItems) {
                return [
                    'success' => false,
                    'message' => 'Your cart is empty'
                ];
            }

            // Create the order
            $order = new Order();
            $order->user_id = $userId;
            $order->payment_status = 'pending';
            $order->delivery_status = 'processing';
            $order->order_status = 'confirmed';
            $order->status = 'Pending';
            $order->name = Auth::user()->name;
            $order->rec_address = $Address->address;
            $order->phone = Auth::user()->phone;
            $order->product_id = $cartItems[0]->product_id ?? null;
            $order->quantity = $cartItems[0]->quantity ?? null;
            $order->invoice_no = 'INV-' . time(); // Ensure invoice number is generated
            $order->save();

           
            // Clear the cart after successful order creation
            Cart::where('user_id', $userId)->delete();

            // Calculate total
            $total = $this->calculateOrderTotal($order);
        
            // Dispatch the OrderPlaced event
            event(new \App\Events\OrderPlaced($order));

            return [
                'success' => true,
                'message' => 'Order confirmed successfully',
                'order' => $order,
                'total' => $total
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to confirm order: ' . $e->getMessage()
            ];
        }
    }
    public function myOrders()
    {
        try {
            $userId = Auth::id();
            $orders = Order::with('product')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return [
                'success' => true,
                'orders' => $orders
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch orders: ' . $e->getMessage()
            ];
        }
    }



    public function calculateOrderTotal(Order $order)
    {
        if ($order->product) {
            return $order->product->price * $order->quantity;
        }
        return 0; // Return 0 if no product is found
    }
}
