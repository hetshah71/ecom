<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    @include('home.css')
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class="hero_area">

        @include('home.header')

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session()->has('order_success'))
            <div class="mb-8">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm" role="alert">
                    <p class="font-medium">{{ session()->get('order_success') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="sm:flex sm:items-center px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Product Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Delivery Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Image</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-all duration-200 ease-in-out">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-base font-medium text-gray-900">{{$order->product->title}}</div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-base font-medium text-gray-900">${{number_format($order->product->price, 2)}}</div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full shadow-sm
                                        @if($order->status == 'processing') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @elseif($order->status == 'delivered') bg-green-100 text-green-800 border border-green-200
                                        @else bg-gray-100 text-gray-800 border border-gray-200
                                        @endif">
                                        {{ucfirst($order->status)}}
                                    </span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex-shrink-0 h-28 w-28 overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                        <img src="{{ asset('storage/'.$order->product->image) }}" alt="Product image" class="h-full w-full object-cover transform hover:scale-105 transition-transform duration-300">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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