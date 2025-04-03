<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\StaticBlock;
use Exception;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add_cart($id)
    {
        try {
            return $this->cartService->addToCart($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add item to cart!');
        }
    }

    public function mycart()
    {
        try {
            $data = $this->cartService->getUserCart();
            return view('home.mycart', $data);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve cart items!');
        }
    }

    public function remove_cart($id)
    {
        try {
            return $this->cartService->removeCartItem($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove item from cart!');
        }
    }

    public function confirm_order(Request $request)
    {   
        try {
            return $this->cartService->confirmOrder($request);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to confirm order!');
        }
    }
}
