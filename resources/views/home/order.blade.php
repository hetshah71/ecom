<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @include('home.css')
    <style type="text/css">
        .div_center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        table {
            border: 2px solid black;
            text-align: center;
            width: 800px;
        }

        th {
            border: 2px solid skyblue;
            background-color: black;
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }

        td {
            border: 2px solid skyblue;
            padding: 10px;
        }

        .alert {
            padding: 15px;
            margin: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .success-container {
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
        }
    </style>

</head>

<body>
    <div class="hero_area">

        @include('home.header')

        @if(session()->has('order_success'))
        <div class="success-container">
            <div class="alert alert-success">
                {{ session()->get('order_success') }}
            </div>
        </div>
        @endif

        <div class="div_center">
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Delivery Status</th>
                    <th>Image</th>
                </tr>
                
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->product->title}}</td>
                    <td>{{$order->product->price}}</td>
                    <td>{{$order->status}}</td>
                    <td>
                        <img src="{{ asset('storage/'.$order->product->image) }}" alt="" width="100">
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @include('home.footer')

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Auto-hide success message after 3 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 3000);
        });
    </script>
</body>

</html>