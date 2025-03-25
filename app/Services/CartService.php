<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

class CartService
{
    public function addToCart($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first!'
            ], 401);
        }

        $user = Auth::user();
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Check if product exists in cart
        $existing_cart = Cart::where('product_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing_cart) {
            $existing_cart->quantity += 1;
            $existing_cart->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $id,
                'quantity' => 1,
            ]);
        }

        $cartCount = Cart::where('user_id', $user->id)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cartCount' => $cartCount
        ]);
    }

    public function getUserCart()
    {
        if (!Auth::check()) {
            return ['count' => 0, 'cart' => collect([]), 'user' => null];
        }

        $user = Auth::user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();

        return ['count' => $cart->count(), 'cart' => $cart, 'user' => $user];
    }

    public function removeCartItem($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cart->delete();
        $cartCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully',
            'cartCount' => $cartCount
        ]);
    }

    public function confirmOrder($request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required|max:20',
                'address' => 'required|max:1000'
            ]);

            $cartItems = Cart::where('user_id', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty!'
                ], 400);
            }

            $invoice_no = 'INV-' . time() . '-' . Auth::id();
            $total_amount = 0;

            DB::beginTransaction();

            try {
                foreach ($cartItems as $item) {
                    $product = Product::find($item->product_id);
                    if (!$product) {
                        throw new \Exception('Product not found');
                    }

                    $order = new Order();
                    $order->user_id = Auth::id();
                    $order->product_id = $item->product_id;
                    $order->quantity = $item->quantity;
                    $order->invoice_no = $invoice_no;
                    $order->name = $request->name;
                    $order->phone = $request->phone;
                    $order->rec_address = $request->address;
                    $order->payment_status = 'pending';
                    $order->status = 'in process';
                    $order->delivery_status = 'pending';
                    $order->save();

                    $total_amount += $product->price * $item->quantity;
                }

                Cart::where('user_id', Auth::id())->delete();

                Session::put('invoice_data', [
                    'invoice_no' => $invoice_no,
                    'order_date' => now()->format('F d, Y h:i A'),
                    'customer_name' => $request->name,
                    'customer_phone' => $request->phone,
                    'customer_address' => $request->address,
                    'total_amount' => $total_amount
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'redirect_url' => route('show.invoice', ['invoice_no' => $invoice_no])
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error placing order: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while placing your order. Please try again.'
            ], 500);
        }
    }
}
