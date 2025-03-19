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
            text-align: center;
            font: 20px;
            font-weight: bold;
            padding: 10px;
        }

        td img {
            width: 100px;
            height: 100px;
            justify-content: center;
            align-items: center;
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

        .order_deg {
            padding-right: 100px;

        }

        label {
            display: inline-block;
            width: 150px;
        }

        .div_gap {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="hero_area">

        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
    </div>
    <!-- mycart section -->
    <div class="div_deg">
        <div class="order_deg">
            <form action="{{url('confirm_order')}}" method="post">
                @csrf
                <div class="div_gap">
                    <label>Receiver Name</label>
                    <input type="text" name="name" value="{{Auth::user()->name}}">
                </div>
                <div class="div_gap">
                    <label>Receiver Address</label>
                    <textarea name="address" >{{Auth::user()->address}}</textarea>
                </div>
                <div class="div_gap">
                    <label>Receiver Phone</label>
                    <input type="text" name="phone" value="{{Auth::user()->phone}}">
                </div>
                <div class="div_gap">
                    <input class="btn btn-success " type="Submit" value="Place order">
                </div>
            </form>
        </div>
        <table>
            <tr>
                <th>Product Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php
            $value = 0;
            ?>
            @foreach($cart as $cart)
            <tr>
                <td>{{ $cart->product->title}}</td>
                <td>{{ $cart->product->price}}</td>
                <td>
                    <img src="{{ asset('storage/'.$cart->product->image) }}" width="250 ">
                </td>
                <td>
                    <form action="{{ route('remove_cart', $cart->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-remove" data-bs-toggle="modal" data-bs-target="#deleteModal{{$cart->id}}">
                            Remove
                        </button>
                    </form>
                </td>
            </tr>
            <?php
            $value = $value + $cart->product->price;
            ?>
            @endforeach
        </table>
    </div>
    <div class="cart_value">
        <h3>Total Value of Cart is : {{$value}}</h3>
    </div>
    <!-- mycart section end-->

    <!-- info section -->
    @include('home.footer')
    <!-- end info section -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>

</html>