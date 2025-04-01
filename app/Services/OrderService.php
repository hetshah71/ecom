<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function confirmOrder($cartItems)
    {
        try {
            $userId = Auth::id();

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
                'invoice_no' => 'INV-' . time() . '-' . $userId,
                'payment_status' => 'pending',
                'delivery_status' => 'processing',
                'order_status' => 'confirmed',
                'status' => 'Pending'
            ]);

            // Attach products to the order with their quantities and prices
            foreach ($cartItems as $item) {
                $order->product()->attach($item->product_id, [
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Clear the cart after successful order creation
            Cart::where('user_id', $userId)->delete();

            return [
                'success' => true,
                'message' => 'Order confirmed successfully',
                'order' => $order
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

    public function showInvoice($invoice_no)
    {
        try {
            $userId = Auth::id();
            $order = Order::with(['products' => function ($query) {
                $query->withPivot(['quantity', 'price']);
            }, 'user'])
                ->where('user_id', $userId)
                ->where('invoice_no', $invoice_no)
                ->firstOrFail();

            if (!$order->products) {
                return [
                    'success' => false,
                    'message' => 'No products found for this order'
                ];
            }

            $total = $order->products->sum(function ($product) {
                return $product->pivot->price * $product->pivot->quantity;
            });

            return [
                'success' => true,
                'order' => $order,
                'total' => $total
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to fetch invoice: ' . $e->getMessage()
            ];
        }
    }
}
