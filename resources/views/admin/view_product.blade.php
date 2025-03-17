<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .table_deg {
            width: 90%;
            border: 2px solid greenyellow;
            margin: auto;
            padding: 20px;
            overflow-x: auto;
        }

        th {
            background-color: skyblue;
            color: white;
            font-size: 20px;
            font-weight: bold;
            padding: 15px;
        }

        td {
            border: 1px solid skyblue;
            text-align: center;
            padding: 10px;
            color: white;

        }

        img {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="text-center" style="margin-top: 20px; font-size: 25px;">All Products</h2>
                <div class="div_deg">
                    <table class="table_deg">
                        <tr>
                            <th>Product Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price(₹)</th>
                            <th>Quantity</th>
                            <th>Image</th>
                        </tr>
                        @foreach($product as $products)
                        <tr>
                            <td>{{$products->title}}</td>
                            <td>{!!Str::limit($products->description,50)!!}</td>
                            <td>{{$products->category}}</td>
                            <td>{{$products->price}}</td>
                            <td>{{$products->quantity}}</td>
                            <td>
                                <img src="{{ asset('storage/'.$products->image) }}" alt="{{$products->title}}">
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
                <div class="div_deg">
                    {{ $product->onEachSide(3)->links() }}
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>