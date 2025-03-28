
<div class="container-fluid px-4 py-6">
    <h2 class="text-3xl font-bold text-white mb-6">Dashboard Overview</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 rounded-xl p-6 shadow-xl hover:shadow-2xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-amber-600/20 rounded-lg">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-100">Total Clients</h3>
                </div>
                <span class="text-2xl font-bold text-amber-500">{{ $user }}</span>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 shadow-xl hover:shadow-2xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-600/20 rounded-lg">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-100">Total Products</h3>
                </div>
                <span class="text-2xl font-bold text-blue-500">{{ $product }}</span>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 shadow-xl hover:shadow-2xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-emerald-600/20 rounded-lg">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-100">Total Orders</h3>
                </div>
                <span class="text-2xl font-bold text-emerald-500">{{ $order }}</span>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 shadow-xl hover:shadow-2xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-purple-600/20 rounded-lg">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-100">Total Delivered</h3>
                </div>
                <span class="text-2xl font-bold text-purple-500">{{ $delivered }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-800 rounded-xl shadow-xl p-6">
            <h3 class="text-xl font-semibold text-white mb-4">Recent Orders</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="p-3 text-sm font-bold text-gray-100 text-left">Customer</th>
                            <th class="p-3 text-sm font-bold text-gray-100 text-left">Product</th>
                            <th class="p-3 text-sm font-bold text-gray-100 text-left">Status</th>
                            <th class="p-3 text-sm font-bold text-gray-100 text-left">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($orders->take(5) as $order)
                        <tr class="hover:bg-gray-700/50 transition-colors duration-200">
                            <td class="p-3 text-sm text-gray-300">{{ $order->name }}</td>
                            <td class="p-3 text-sm text-gray-300">{{ $order->product->title }}</td>
                            <td class="p-3">
                                @if($order->status == 'in process')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-amber-600/20 text-amber-500">
                                    {{ $order->status }}
                                </span>
                                @elseif($order->status == 'on the way')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-600/20 text-blue-500">
                                    {{ $order->status }}
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-600/20 text-emerald-500">
                                    {{ $order->status }}
                                </span>
                                @endif
                            </td>
                            <td class="p-3 text-sm text-gray-300">${{ number_format($order->product->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

       
    </div>
</div>

