<!DOCTYPE html>
<html>

<head>
    
    @include('home.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        table {
            border: 2px solid black;
            text-align: center;
            width: 80%;
            margin: auto;
        }

        th {
            border: 2px solid black;
            text-align: center;
            color: white;
            font: 20px;
            font-weight: bold;
            background-color: black;
        }

        td {
            border: 2px solid skyblue;
        }

        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-remove:hover {
            background-color: #c82333;
        }

        .cart_value {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
        }

        .alert {
            padding: 15px;
            margin: 20px auto;
            border: 1px solid transparent;
            border-radius: 4px;
            max-width: 800px;
            text-align: center;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        #cart-message {
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
    </div>

    <!-- Message Display -->
    <div id="cart-message" style="display: none;"></div>

    <!-- mycart section -->
    <div class="div_deg">
        @if($cart->count() > 0)
        <table>
            <tr>
                <th>Product Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php $value = 0; ?>
            @foreach($cart as $cartItem)
            <tr>
                <td>{{ $cartItem->product->title}}</td>
                <td>{{ $cartItem->product->price}}</td>
                <td>{{ $cartItem->quantity }}</td>
                <td>{{ $cartItem->product->price * $cartItem->quantity }}</td>
                <td>
                    <img src="{{ asset('storage/'.$cartItem->product->image) }}" width="100px" height="100px">
                </td>
                <td>
                    <button type="button" class="btn-remove" data-cart-id="{{$cartItem->id}}">
                        Remove
                    </button>
                </td>
            </tr>
            <?php $value = $value + ($cartItem->product->price * $cartItem->quantity); ?>
            @endforeach
        </table>
        <div class="cart_value">
            <h3>Total Value of Cart is : {{$value}}</h3>
        </div>

        <!-- Order Form -->
        <div class="form-container">
            <h4 class="text-center mb-4">Place Order</h4>
            <form id="order-form" method="POST" action="{{ route('confirm_order') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{$user->phone}}" required>
                </div>
                <div class="form-group">
                    <label for="address">Delivery Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
        @else
        <div class="text-center">
            <h3>Your cart is empty!</h3>
            <p>Add some products to your cart before placing an order.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
        @endif
    </div>
    <!-- mycart section end-->

    <!-- info section -->
    @include('home.footer')
    <!-- end info section -->

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include cart.js for AJAX functionality -->
    <!-- <script src="{{ asset('js/cart.js') }}"></script> -->
</body>

</html>