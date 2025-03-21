<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
    </div>
    <!-- end hero area -->

    <!-- Message Display -->
    <div id="cart-message" class="container mt-3" style="display: none;"></div>

    <!-- shop section -->
    @include('home.product')
    <!-- end shop section -->

    <!-- info section -->
    @include('home.footer')
    <!-- end info section -->

    <!-- Include cart.js for AJAX functionality -->
    <script src="{{ asset('js/cart.js') }}"></script>
</body>

</html>