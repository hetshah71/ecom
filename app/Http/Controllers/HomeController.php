<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\StaticBlock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        try {
            $user = User::where('usertype', 'user')->count();
            $product = Product::count();
            $order = Order::count();
            $delivered = Order::where('status', 'Delivered')->count();
            $orders = Order::with('product')->latest()->get();
            return view('admin.index', compact('user', 'product', 'order', 'delivered', 'orders'));
        } catch (\Exception $e) {
            Log::error('Error fetching index data: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading data.');
        }
    }

    public function home()
    {
        try {
            $products = Product::all();
            $count = Auth::check() ? Cart::where('user_id', Auth::id())->count() : '';
            $block = StaticBlock::where('slug', 'hello')->first();
            return view('home.index', compact('products', 'count', 'block'));
        } catch (\Exception $e) {
            Log::error('Error loading home page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the home page.');
        }
    }

    public function login_home()
    {
        return $this->home();
    }

    public function product_details(string $slug)
    {
        try {
            $data = Product::where('slug', $slug)->firstOrFail();
            $count = Auth::check() ? Cart::where('user_id', Auth::id())->count() : '';
            return view('home.product_details', compact('data', 'count'));
        } catch (\Exception $e) {
            Log::error('Error loading product details: ' . $e->getMessage());
            return back()->with('error', 'Product not found.');
        }
    }

    // public function mycart()
    // {
    //     try {
    //         $user = Auth::user();
    //         $count = Auth::check() ? Cart::where('user_id', $user->id)->count() : '';
    //         $cart = Auth::check() ? Cart::with('product')->where('user_id', $user->id)->get() : collect([]);
    //         return view('home.mycart', compact('count', 'cart', 'user'));
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching cart data: ' . $e->getMessage());
    //         return back()->with('error', 'An error occurred while loading your cart.');
    //     }
    // }

    // public function remove_cart($id)
    // {
    //     try {
    //         $cart = Cart::findOrFail($id);
    //         $cart->delete();
    //         $cartCount = Cart::where('user_id', Auth::id())->count();
    //         return response()->json(['success' => true, 'message' => 'Product removed from cart successfully', 'cartCount' => $cartCount]);
    //     } catch (\Exception $e) {
    //         Log::error('Error removing cart item: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Error removing product from cart'], 500);
    //     }
    // }

    // public function confirm_order(Request $request)
    // {
    //     try {
    //         $request->validate(['name' => 'required|max:255', 'phone' => 'required|max:20', 'address' => 'required|max:1000']);
    //         $cartItems = Cart::where('user_id', Auth::id())->get();
    //         if ($cartItems->isEmpty()) {
    //             return response()->json(['success' => false, 'message' => 'Your cart is empty!'], 400);
    //         }
    //         DB::beginTransaction();
    //         $invoice_no = 'INV-' . time() . '-' . Auth::id();
    //         $total_amount = 0;

    //         foreach ($cartItems as $item) {
    //             $order = new Order();
    //             $order->user_id = Auth::id();
    //             $order->product_id = $item->product_id;
    //             $order->quantity = $item->quantity;
    //             $order->invoice_no = $invoice_no;
    //             $order->name = $request->name;
    //             $order->phone = $request->phone;
    //             $order->rec_address = $request->address;
    //             $order->payment_status = 'pending';
    //             $order->status = 'in process';
    //             $order->delivery_status = 'pending';
    //             $order->save();
    //             $total_amount += $order->total_price;
    //         }
    //         Cart::where('user_id', Auth::id())->delete();
    //         Session::put('invoice_data', compact('invoice_no', 'total_amount'));
    //         DB::commit();
    //         return response()->json(['success' => true, 'message' => 'Order placed successfully!', 'redirect_url' => route('show.invoice', ['invoice_no' => $invoice_no])]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error placing order: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'An error occurred while placing your order. Please try again.'], 500);
    //     }
    // }

    // public function showInvoice($invoice_no)
    // {
    //     try {
    //         $orders = Order::with(['product', 'user'])->where('invoice_no', $invoice_no)->get();
    //         if ($orders->isEmpty()) {
    //             return redirect()->route('myorders')->with('error', 'Invoice not found.');
    //         }

    //         $firstOrder = $orders->first();
    //         $invoice_data = [
    //             'invoice_no' => $invoice_no,
    //             'order_date' => $firstOrder->created_at->format('Y-m-d'),
    //             'customer_name' => $firstOrder->user->name,
    //             'customer_phone' => $firstOrder->user->phone ?? 'N/A',
    //             'customer_address' => $firstOrder->user->address ?? 'N/A'
    //         ];


    //         return view('home.invoice', compact('orders', 'invoice_data'));
    //     } catch (\Exception $e) {
    //         Log::error('Error showing invoice: ' . $e->getMessage());
    //         return redirect()->route('myorders')->with('error', 'An error occurred while loading the invoice.');
    //     }
    // }

    // public function downloadInvoice($invoice_no)
    // {
    //     try {
    //         $orders = Order::with(['product', 'user'])->where('invoice_no', $invoice_no)->get();
    //         if ($orders->isEmpty()) {
    //             return redirect()->route('myorders')->with('error', 'Invoice not found.');
    //         }

    //         $firstOrder = $orders->first();
    //         $invoice_data = [
    //             'invoice_no' => $invoice_no,
    //             'order_date' => $firstOrder->created_at->format('Y-m-d'),
    //             'customer_name' => $firstOrder->user->name,
    //             'customer_phone' => $firstOrder->user->phone ?? 'N/A',
    //             'customer_address' => $firstOrder->user->address ?? 'N/A'
    //         ];

    //         $pdf = Pdf::loadView('home.pdf_invoice', compact('orders', 'invoice_data'));
    //         return $pdf->download($invoice_no . '.pdf');
    //     } catch (\Exception $e) {
    //         Log::error('Error generating PDF invoice: ' . $e->getMessage());
    //         return redirect()->route('myorders')->with('error', 'An error occurred while generating the PDF.');
    //     }
    // }
    public function shop()
    {
        try {
            $products = Product::all();
            return view('home.shop', compact('products'));
        } catch (\Exception $e) {
            Log::error('Error loading shop page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the shop page.');
        }
    }

    public function why()
    {
        try {
            return view('home.why');
        } catch (\Exception $e) {
            Log::error('Error loading why page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the page.');
        }
    }
    public function contact()
    {
        try {
            return view('home.contact');
        } catch (\Exception $e) {
            Log::error('Error loading contact page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the page.');
        }
    }
    public function testimonial()
    {
        try {
            return view('home.testimonial');
        } catch (\Exception $e) {
            Log::error('Error loading testimonial page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the page.');
        }
    }
}
