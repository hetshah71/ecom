<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class OrderController extends Controller
{
    public function view_orders()
    {
        try {
            $orders = Order::with('product')->paginate(1);
            return view('admin.order', compact('orders'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch orders: ' . $e->getMessage());
        }
    }

    public function on_the_way($id)
    {
        try {
            $data = Order::find($id);
            if ($data) {
                $data->status = 'On the way';
                $data->save();
                return redirect('/admin/view_orders')->with('success', 'Order status updated to On the Way.');
            } else {
                return redirect()->back()->with('error', 'Order not found.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    public function delivered($id)
    {
        try {
            $data = Order::find($id);
            if ($data) {
                $data->status = 'Delivered';
                $data->save();
                return redirect('/admin/view_orders')->with('success', 'Order status updated to Delivered.');
            } else {
                return redirect()->back()->with('error', 'Order not found.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    public function print_pdf($id)
    {
        try {
            $data = Order::find($id);
            if (!$data) {
                return redirect()->back()->with('error', 'Order not found.');
            }

            $pdf = Pdf::loadView('admin.invoice', compact('data'));
            return $pdf->download('invoice.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
}
