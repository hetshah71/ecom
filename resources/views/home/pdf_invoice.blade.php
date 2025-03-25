<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .customer-details {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Order Invoice</h1>
        </div>

        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <p>Invoice No: {{ $invoice_data['invoice_no'] }}</p>
            <p>Order Date: {{ $invoice_data['order_date'] }}</p>
        </div>

        <div class="customer-details">
            <h3>Customer Details</h3>
            <p>Name: {{ $invoice_data['customer_name'] }}</p>
            <p>Phone: {{ $invoice_data['customer_phone'] }}</p>
            <p>Address: {{ $invoice_data['customer_address'] }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->product->title }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>${{ number_format($order->product->price, 2) }}</td>
                    <td>${{ number_format($order->quantity * $order->product->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Total Amount:</td>
                    <td>
                        ${{ number_format($orders->sum(function($order) {
                            return $order->quantity * $order->product->price;
                        }), 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>