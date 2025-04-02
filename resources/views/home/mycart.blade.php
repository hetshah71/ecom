<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50">
    <div class="hero_area">
        @include('home.header')
    </div>

    <div id="cart-message" class="max-w-4xl mx-auto mt-8 text-center hidden"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($cart->count() > 0)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Product Title</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Price</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Quantity</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Total</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Image</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $value = 0; ?>
                    @foreach($cart as $cartItem)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cartItem->product->title}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ $cartItem->product->price}}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cartItem->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ $cartItem->product->price * $cartItem->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset('storage/'.$cartItem->product->image) }}" class="h-24 w-24 object-contain rounded-md shadow-sm" alt="Product image" loading="lazy">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 btn-remove" data-cart-id="{{$cartItem->id}}">
                                Remove
                            </button>
                        </td>
                    </tr>
                    <?php $value = $value + ($cartItem->product->price * $cartItem->quantity); ?>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Total Cart Value: ${{$value}}</h3>

            <div class="max-w-3xl mx-auto">
                <h4 class="text-xl font-semibold text-gray-900 mb-6">Place Order</h4>
                <form id="order-form" method="POST" action="{{ route('confirm_order') }}" class="space-y-6" novalidate>
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" value="{{$user->name}}" required minlength="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{$user->phone}}" required pattern="\d{10,}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                        <textarea id="address" name="address" rows="3" required minlength="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty!</h3>
            <p class="text-gray-600 mb-8">Add some products to your cart before placing an order.</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                Continue Shopping
            </a>
        </div>
        @endif
    </div>

    @include('home.footer')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/order-validation.js') }}"></script>
</body>

</html>