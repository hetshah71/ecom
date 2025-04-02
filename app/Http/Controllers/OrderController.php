<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderPlaced;
use App\Models\Order;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string'
        ]);

        $cartItems = Auth::user()->cart;
        $result = $this->orderService->confirmOrder($cartItems, $request->address);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        $order = $result['order'];
        event(new OrderPlaced($order));

        return redirect()->route('mycart')->with('success', 'Order placed successfully!');
    }

    public function show()
    {
        //     $result = $this->orderService->myOrders();
        //     if (!$result['success']) {
        //         return redirect()->back()->with('error', $result['message']);
        //     }

        //     return view('home.order', ['orders' => $result['orders']]);
        try {
            $userId = Auth::id(); // Get the authenticated user ID

            $orders = Order::where('user_id', $userId) // Load related order items if needed
                ->orderBy('created_at', 'desc')
                ->get();
                // dd($orders);

            return view('home.order', compact('orders'));
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to retrieve orders: ' . $e->getMessage(),
            ];
        }
    }

    
}
