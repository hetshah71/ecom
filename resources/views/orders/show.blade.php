<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
                        <h4 class="mb-0">Order Confirmation</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Thank you for your order!</h5>
                            <p>Invoice No: {{ $order->invoice_no }}</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6>Customer Details</h6>
                                <p>Name: {{ $order->user->name }}</p>
                                <p>Email: {{ $order->user->email }}</p>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <h6>Order Status</h6>
                                <p>Payment Status: {{ ucfirst($order->payment_status) }}</p>
                                <p>Delivery Status: {{ ucfirst($order->delivery_status) }}</p>
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
                                    @foreach($order->products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 50px; height: 50px; object-fit: cover;" class="mr-2">
                                                @endif
                                                {{ $product->title }}
                                            </div>
                                        </td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>${{ number_format($product->pivot->price, 2) }}</td>
                                        <td>${{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                                        <td>
                                            <strong>
                                                ${{ number_format($order->products->sum(function($product) {
                                                    return $product->pivot->quantity * $product->pivot->price;
                                                }), 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>