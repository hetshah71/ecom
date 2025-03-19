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
                        @foreach($data as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->rec_address}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->product->title}}</td>
                            <td>{{$data->product->price}}</td>
                            <td>
                                <img src="{{asset('storage/'.$data->product->image)}}" alt="{{$data->product->title}}" width="100px">
                            </td>
                            <td>
                                @if($data->status == 'in process')
                                <span style="color:red; font-weight:bold" >{{$data->status}}</span>
                                @else
                                <span>{{$data->status}}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{url('/admin/on_the_way',$data->id)}}">On the way</a>
                                <a class="btn btn-success" href="{{url('/admin/delivered',$data->id)}}">Delivered</a>
                            </td>
                            <td>
                                <a class="btn btn-secondary"href="{{url('/admin/print_pdf',$data->id)}}">Print PDF</a>
        
                                </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
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