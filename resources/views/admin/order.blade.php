<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style type="text/css">
        table {
            border: 2px solid skyblue;
            text-align: center;
        }

        th {
            background-color: skyblue;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .table_center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        td {
            border: 2px solid skyblue;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            width: 200px;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <div class="table_center">
                    <table>
                        <tr>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Phone number</th>
                            <th>product title</th>
                            <th> price</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Change Status</th>
                            <th>Print pdf</th>
                        </tr>

                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->name}}</td>
                            <td>{{$order->rec_address}}</td>
                            <td>{{$order->phone}}</td>
                            <td>{{$order->product->title}}</td>
                            <td>{{$order->product->price}}</td>
                            <td>
                                <img src="{{asset('storage/'.$order->product->image)}}" alt="{{$order->product->title}}" width="100px">
                            </td>
                            <td>
                                @if($order->status == 'in process')
                                <span style="color:red; font-weight:bold">{{$order->status}}</span>
                                @else
                                <span>{{$order->status}}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{url('/admin/on_the_way',$order->id)}}">On the way</a>
                                <a class="btn btn-success" href="{{url('/admin/delivered',$order->id)}}">Delivered</a>
                            </td>
                            <td>
                                <a class="btn btn-secondary" href="{{url('/admin/print_pdf',$order->id)}}">Print PDF</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}">
    </script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>