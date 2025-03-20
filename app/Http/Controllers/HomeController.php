<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\User;
use App\Models\Cart;
use App\Models\order;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('usertype', 'user')->get()->count();
        $product = Product::all()->count();
        $order = Order::all()->count();
        $delivered = Order::where ('status', 'Delivered')->get()->count();
        return view('admin.index', compact('user', 'product', 'order' , 'delivered'));
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
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;
        $data->save();
        session()->flash('success', 'Product added to the Cart successfully');
        return redirect()->back();
    }
    public function mycart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::where('user_id', $userid)->get();
        } else {
            $count = '';
        }

        return view('home.mycart', compact('count', 'cart'));
    }

    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        session()->flash('success', 'Product removed from the Cart successfully');  
        return redirect()->back();
    }
    
    public function confirm_order(Request $request){
        
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone; 
        $userid = Auth::user()->id;
        $cart = cart::where('user_id', $userid)-> get();
        foreach ($cart as $carts){
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $carts->product_id;
            $order->save();
            
        }
        $cart_remove = cart::where('user_id',$userid)->get();
        $cart_remove = cart::where('user_id', $userid)->get();
        foreach ($cart_remove as $remove) {
            Cart::find($remove->id)->delete();
        }
         session()->flash('success', 'Product ordered successfully');
        return redirect()->back();
    }
    public function myorders()
    {
        $user = Auth::user()->id;
        $count = cart::where('user_id',$user)->get()->count();
        $order = Order::where('user_id', $user)->get();
        return view('home.order',compact('count','order'));
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

        return view('home.why', compact( 'count'));
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
