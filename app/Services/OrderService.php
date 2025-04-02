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

            // Eager load the products relationship
            $cartItems = Cart::with('product')
                ->where('user_id', $userId)
                ->get();

            if ($cartItems->isEmpty()) {
                return [
                    'success' => false,
                    'message' => 'Your cart is empty'
                ];
            }

            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'payment_status' => 'pending',
                'delivery_status' => 'processing',
                'order_status' => 'confirmed',
                'status' => 'Pending'
            ]);

            // Attach products to the order with their quantities and prices
            foreach ($cartItems as $item) {
                $order->products()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Clear the cart after successful order creation
            Cart::where('user_id', $userId)->delete();

            // Calculate total
            $total = $this->calculateOrderTotal($order);

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
        return $order->products()->get()->sum(function ($product) {
            return $product->pivot->price * $product->pivot->quantity;
        });
    }
}
