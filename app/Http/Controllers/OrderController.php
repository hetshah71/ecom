<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Events\OrderPlaced;
use App\Events\InvoiceGenerated;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(Request $request)
    {
        $cartItems = Auth::user()->cart;
        $result = $this->orderService->confirmOrder($cartItems);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        $order = $result['order'];
        event(new OrderPlaced($order));

        $pdf = Pdf::loadView('pdf.invoice', compact('order'))->output();
        event(new InvoiceGenerated($order, $pdf));

        return redirect()->route('myorders')->with('success', 'Order placed successfully!');
    }

    public function show()
    {
        $result = $this->orderService->myOrders();
        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return view('home.order', ['orders' => $result['orders']]);
    }

    public function showInvoice($invoice_no)
    {
        $result = $this->orderService->showInvoice($invoice_no);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return view('home.invoice', ['order' => $result['order'], 'total' => $result['total']]);
    }

    public function downloadInvoice($invoice_no)
    {
        $result = $this->orderService->showInvoice($invoice_no);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        $pdf = Pdf::loadView('pdf.invoice', ['order' => $result['order']]);
        return $pdf->download('invoice-' . $invoice_no . '.pdf');
    }
}
