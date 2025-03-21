<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <style>
        .invoice-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .invoice-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .invoice-title {
            color: #333;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .invoice-details-left,
        .invoice-details-right {
            flex: 1;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 0 10px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .invoice-table th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }

        .invoice-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .total-row {
            font-weight: bold;
            background: #f8f9fa;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
            animation: fadeIn 0.5s ease-in;
        }

        .print-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
            }

            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }

            .invoice-details-left, .invoice-details-right {
                background: none;
            }

            .invoice-table th {
                background: #f8f9fa !important;
                color: #333 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="hero_area">
        @include('home.header')
    </div>

    <div class="invoice-container">
        @if(session('order_success'))
        <div class="success-message">
            {{ session('order_success') }}
        </div>
        @endif

        <div class="invoice-header">
            <h1 class="invoice-title">INVOICE</h1>
            <p>Invoice No: {{ $invoice_data['invoice_no'] }}</p>
            <p>Date: {{ $invoice_data['order_date'] }}</p>
        </div>

        <div class="invoice-details">
            <div class="invoice-details-left">
                <h3>Bill To:</h3>
                <p><strong>Name:</strong> {{ $invoice_data['customer_name'] }}</p>
                <p><strong>Phone:</strong> {{ $invoice_data['customer_phone'] }}</p>
                <p><strong>Address:</strong> {{ $invoice_data['customer_address'] }}</p>
            </div>
            <div class="invoice-details-right">
                <h3>From:</h3>
                <p><strong>Giftos</strong></p>
                <p>123 Business Street</p>
                <p>City, Country</p>
                <p>Phone: (123) 456-7890</p>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->product->title }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>${{ number_format($order->product->price, 2) }}</td>
                    <td>${{ number_format($order->product->price * $order->quantity, 2) }}</td>
                </tr>
                @php $total += ($order->product->price * $order->quantity); @endphp
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right"><strong>Total Amount:</strong></td>
                    <td><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="no-print" style="text-align: center">
            <button onclick="window.print()" class="print-button">
                <i class="fa fa-print"></i> Print Invoice
            </button>
            <a href="{{ route('myorders') }}" class="print-button" style="text-decoration: none; display: inline-block; margin-left: 10px;">
                <i class="fa fa-list"></i> View All Orders
            </a>
        </div>
    </div>

    @include('home.footer')

    <script>
        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 500);
            }
        }, 5000);
    </script>
</body>

</html>