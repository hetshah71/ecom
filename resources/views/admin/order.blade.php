<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content bg-gray-900">
        <div class="page-header">
            <div class="container-fluid px-4 py-6">
                <h2 class="text-3xl font-bold text-white mb-6">Order Management</h2>
                <div class="bg-gray-800 rounded-xl shadow-xl">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-700 bg-gray-800">
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Customer Name</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Address</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Phone Number</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Product Title</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Price</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Image</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Status</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Actions</th>
                                <th class="p-3 text-sm font-bold text-gray-100 uppercase tracking-wider">Invoice</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-700 transition-colors duration-200">
                                <td class="p-1.5 text-sm text-gray-300">{{$order->name}}</td>
                                <td class="p-1.5 text-sm text-gray-300">{{$order->rec_address}}</td>
                                <td class="p-1.5 text-sm text-gray-300">{{$order->phone}}</td>
                                <td class="p-1.5 text-sm text-gray-300">{{$order->product->title}}</td>
                                <td class="p-1.5 text-sm text-gray-300">${{number_format($order->product->price, 2)}}</td>
                                <td class="p-1.5">
                                    <img class="w-20 h-20 object-cover shadow-md hover:scale-105 transition-transform duration-200" src="{{asset('storage/'.$order->product->image)}}" alt="{{$order->product->title}}">
                                </td>
                                <td class="p-1.5">
                                    @if($order->status == 'in process')
                                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-amber-600 text-amber-100 shadow-sm">{{$order->status}}</span>
                                    @elseif($order->status == 'on the way')
                                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-blue-600 text-blue-100 shadow-sm">{{$order->status}}</span>
                                    @else
                                    <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-emerald-600 text-emerald-100 shadow-sm">{{$order->status}}</span>
                                    @endif
                                </td>
                                <td class="p-1.5 space-x-1">
                                    <a href="{{url('/admin/on_the_way',$order->id)}}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        On the way
                                    </a>
                                    <a href="{{url('/admin/delivered',$order->id)}}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 shadow-sm">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Delivered
                                    </a>
                                </td>
                                <td class="p-1.5">
                                    <a href="{{url('/admin/print_pdf',$order->id)}}" class="inline-flex items-center px-2.5 py-1.5 text-sm font-medium text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">Print PDF</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mt-4">
                    <div class="pagination-dark">
                        {{ $orders->links()->with(['class' => 'pagination-dark']) }}
                        <style>
                            .pagination-dark nav[role=navigation] {
                                background-color: #1f2937;
                                border-radius: 0.5rem;
                                padding: 0.5rem;
                            }

                            .pagination-dark .flex.justify-between.flex-1 {
                                display: none;
                            }

                            .pagination-dark .flex.items-center.-mt-px.w-0.flex-1 button,
                            .pagination-dark .flex.items-center.-mt-px.w-0.flex-1 span {
                                color: #9ca3af;
                                padding: 0.5rem 1rem;
                                border-radius: 0.375rem;
                                transition: all 0.2s;
                            }

                            .pagination-dark .flex.items-center.-mt-px.w-0.flex-1 button:hover {
                                background-color: #374151;
                                color: #ffffff;
                            }

                            .pagination-dark span[aria-current=page] span {
                                background-color: #4b5563;
                                color: #ffffff;
                            }

                            .pagination-dark .relative.inline-flex.items-center {
                                margin: 0 0.25rem;
                            }
                        </style>
                    </div>
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
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>