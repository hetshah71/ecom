<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
    <link href="/css/style.css" rel="stylesheet" />
    <link href="/css/responsive.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Order Invoice</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Invoice Details</h5>
                            <p>Invoice No: {{ $invoice_data['invoice_no'] }}</p>
                            <p>Order Date: {{ $invoice_data['order_date'] }}</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Customer Details</h6>
                                <p>Name: {{ $invoice_data['customer_name'] }}</p>
                                <p>Phone: {{ $invoice_data['customer_phone'] }}</p>
                                <p>Address: {{ $invoice_data['customer_address'] }}</p>
                            </div>
                        </div>

                        <h6>Order Items</h6>
                        <div class="table-responsive">
                            <table class="table">
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
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($order->product->image)
                                                <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->title }}" style="width: 50px; height: 50px; object-fit: cover;" class="mr-2">
                                                @endif
                                                {{ $order->product->title }}
                                            </div>
                                        </td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>${{ number_format($order->product->price, 2) }}</td>
                                        <td>${{ number_format($order->quantity * $order->product->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                                        <td>
                                            <strong>
                                                ${{ number_format($orders->sum(function($order) {
                                                    return $order->quantity * $order->product->price;
                                                }), 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                            <a href="{{ route('download.invoice', ['invoice_no' => $invoice_data['invoice_no']]) }}" class="btn btn-secondary ms-2">Download PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>