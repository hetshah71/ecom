<!DOCTYPE html>
<html>

<head>
    <title>Terms and Conditions</title>
    @include('home.css')
</head>

<body class="bg-gray-100">
    @include('home.flash-message')
    <div class="hero_area">
        <!-- Header Section -->
        @include('home.header')
        <!-- End Header Section -->
    </div>
  
    {!! $page->content !!}
<!-- 
    <section class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-10 mb-10 animate-fadeIn">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Terms and Conditions</h1>
        <p class="text-gray-600 leading-relaxed">Welcome to our eCommerce website. By accessing and using our website, you agree to comply with and be bound by the following terms and conditions.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">1. Introduction</h2>
        <p class="text-gray-600 leading-relaxed">These terms and conditions govern your use of our website. Please read them carefully before making any purchase.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">2. User Accounts</h2>
        <p class="text-gray-600 leading-relaxed">To place an order, you may need to create an account. You are responsible for maintaining the confidentiality of your account details.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">3. Orders and Payments</h2>
        <p class="text-gray-600 leading-relaxed">All orders placed are subject to availability and confirmation of the order price. We reserve the right to refuse any order.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">4. Shipping and Delivery</h2>
        <p class="text-gray-600 leading-relaxed">Shipping times may vary depending on your location. We are not responsible for delays caused by third-party shipping providers.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">5. Returns and Refunds</h2>
        <p class="text-gray-600 leading-relaxed">We offer returns within a specific period after purchase. Items must be in their original condition to qualify for a refund.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">6. Limitation of Liability</h2>
        <p class="text-gray-600 leading-relaxed">We are not responsible for any indirect or consequential loss incurred by the use of our website or products.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">7. Changes to Terms</h2>
        <p class="text-gray-600 leading-relaxed">We reserve the right to modify these terms at any time. Please review them regularly.</p>

        <h2 class="text-2xl font-semibold text-blue-600 mt-6">8. Contact Information</h2>
        <p class="text-gray-600 leading-relaxed">If you have any questions about these Terms and Conditions, please contact us at support@example.com.</p>
    </section> -->

    <!-- Footer Section -->
    @include('home.footer')
    <!-- End Footer Section -->
</body>

</html>