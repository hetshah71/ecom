<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('usertype', 'user')->get()->count();
        $product = Product::all()->count();
        $order = Order::all()->count();
        $delivered = Order::where('status', 'Delivered')->get()->count();
        return view('admin.index', compact('user', 'product', 'order', 'delivered'));
    }

    public function home()
    {
        $product = product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.index', compact('product', 'count'));
    }
    public function login_home()
    {
        $product = product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.index', compact('product', 'count'));
    }
    public function product_details(string $slug)
    {
        $data = product::where('slug', $slug)->firstOrFail();
        // dd($data)/;
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.product_details', compact('data', 'count'));
    }
    public function add_cart($id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Check if product already exists in cart
            $existing_cart = Cart::where('product_id', $id)
                ->where('user_id', $userid)
                ->first();

            if ($existing_cart) {
                // Update quantity if product exists
                $existing_cart->quantity += 1;
                $existing_cart->save();
            } else {
                // Add new product to cart
                $cart = new Cart();
                $cart->user_id = $userid;
                $cart->product_id = $id;
                $cart->quantity = 1;
                $cart->save();
            }

            // Get updated cart count (sum of all quantities)
            $cartCount = Cart::where('user_id', $userid)->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cartCount' => $cartCount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Please login first!'
            ], 401);
        }
    }
    public function mycart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::with('product')->where('user_id', $userid)->get();

        } else {
            $count = '';
            $cart = collect([]);
        }

        return view('home.mycart', compact('count', 'cart','user'));
    }

    public function remove_cart($id)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing product from cart'
            ], 500);
        }
    }

    public function confirm_order(Request $request)
    {
      
        try {
           
            // Validate request
            $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required|max:20',
                'address' => 'required|max:1000'
            ]);
           
          

            // Get user's cart items
            $cartItems = Cart::where('user_id', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty!'
                ], 400);
            }

            // Generate unique invoice number
            $invoice_no = 'INV-' . time() . '-' . Auth::id();
            $total_amount = 0;

            // Start database transaction
            DB::beginTransaction();

            try {
                // Create orders for each cart item
                foreach ($cartItems as $item) {
                    $order = new Order();
                    $order->user_id = Auth::id();
                    $order->product_id = $item->product_id;
                    $order->quantity = $item->quantity;
                    // $order->price = $item->product->price;
                    // $order->total_price = $item->quantity * $item->product->price;
                    $order->invoice_no = $invoice_no;
                    $order->name = $request->name;
                    $order->phone = $request->phone;
                    $order->rec_address = $request->address;
                    $order->payment_status = 'pending';
                    $order->status = 'in process';
                    $order->delivery_status = 'pending';
                    // dd($order);
                    $order->save();

                    $total_amount += $order->total_price;
                }
                

                // Clear the cart
                Cart::where('user_id', Auth::id())->delete();

                // Store invoice data in session
                Session::put('invoice_data', [
                    'invoice_no' => $invoice_no,
                    'order_date' => now()->format('F d, Y h:i A'),
                    'customer_name' => $request->name,
                    'customer_phone' => $request->phone,
                    'customer_address' => $request->address,
                    'total_amount' => $total_amount
                ]);

                // Commit transaction
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'redirect_url' => route('show.invoice', ['invoice_no' => $invoice_no])
                ]);
            } catch (\Exception $e) {
                // Rollback transaction on error
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

    public function showInvoice($invoice_no)
    {
        try {
            $orders = Order::with(['product', 'user'])
                ->where('invoice_no', $invoice_no)
                ->get();

            if ($orders->isEmpty()) {
                return redirect()->route('myorders')->with('error', 'Invoice not found.');
            }

            $invoice_data = Session::get('invoice_data') ?? [
                'invoice_no' => $invoice_no,
                'order_date' => Carbon::parse($orders->first()->created_at)->format('F d, Y h:i A'),
                'customer_name' => $orders->first()->user->name,
                'customer_phone' => $orders->first()->phone,
                'customer_address' => $orders->first()->address
            ];

            return view('home.invoice', compact('orders', 'invoice_data'));
        } catch (\Exception $e) {
            Log::error('Error showing invoice: ' . $e->getMessage(), [
                'invoice_no' => $invoice_no,
                'error' => $e
            ]);
            return redirect()->route('myorders')->with('error', 'An error occurred while loading the invoice.');
        }
    }

    public function myorders()
    {
        $user = Auth::user()->id;
        $count = cart::where('user_id', $user)->get()->count();
        $order = Order::where('user_id', $user)->get();
        return view('home.order', compact('count', 'order'));
    }
    public function shop()
    {
        $product = product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.shop', compact('product', 'count'));
    }

    public function why()
    {

        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.why', compact('count'));
    }

    public function   testimonial()
    {

        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.testimonial', compact('count'));
    }

    public function contact()
    {

        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.contact', compact('count'));
    }
}
