<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        .div_center {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .detail-box {
            padding: 15px;
        }

        /* Add styles for messages */
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
    </div>
    <!-- Product details Start -->
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Latest Products
                </h2>
            </div>
            <div class="row">

                <div class=" col-md-12 ">
                    <div class="box">

                        <div class="div_center">
                            <img width="400" src="{{ asset('storage/'. $data->image ) }}" alt="">
                        </div>
                        <div class="detail-box">
                            <h6>Product : {{$data->title}}</h6>
                            <h6>Price : <span>₹{{$data->price}}</span></h6>
                        </div>

                        <div class="detail-box">
                            <h6>category : {{$data->category}}</h6>
                            <h6>Available Quantity : <span>{{$data->quantity}}</span></h6>
                        </div>

                        <div class="detail-box">

                            <p>description : {{$data->description}}</p>
                        </div>

                        <div class="detail-box">

                            <button class="btn btn-success add-to-cart" data-product-id="{{$data->id}}">Add to Cart</button>
                            <div id="cart-message" class="mt-2"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>




    <!-- Product details end -->
    <!-- info section -->
    @include('home.footer')
    <!-- end info section -->

    <!-- Add jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add custom cart JavaScript -->
    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Remove any existing click handlers
            $('.add-to-cart').off('click');

            // Add to cart button click handler
            $('.add-to-cart').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation(); // Prevent event bubbling

                const productId = $(this).data('product-id');
                const button = $(this);
                const messageDiv = $('#cart-message');

                // If button is already processing, return
                if (button.prop('disabled')) {
                    return;
                }

                // Disable the button while processing
                button.prop('disabled', true);

                $.ajax({
                    url: '/add_cart/' + productId,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            messageDiv.html('<div class="alert alert-success">' + response.message + '</div>');

                            // Update cart count in header
                            if (response.cartCount !== undefined) {
                                $('#cart-count').text(response.cartCount);
                            }
                        } else {
                            messageDiv.html('<div class="alert alert-danger">' + (response.message || 'Error adding to cart') + '</div>');
                        }

                        // Clear message after 2 seconds
                        setTimeout(function() {
                            messageDiv.html('');
                        }, 2000);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        let errorMessage = 'Error adding to cart';

                        if (xhr.status === 401) {
                            errorMessage = 'Please login first';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        messageDiv.html('<div class="alert alert-danger">' + errorMessage + '</div>');

                        setTimeout(function() {
                            messageDiv.html('');
                        }, 2000);
                    },
                    complete: function() {
                        // Re-enable the button after request completes
                        setTimeout(function() {
                            button.prop('disabled', false);
                        }, 1000); // Add a small delay before re-enabling the button
                    }
                });
            });
        });
    </script>
</body>

</html>