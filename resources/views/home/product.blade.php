<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Latest Products
            </h2>
        </div>
        <div class="row">
            @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box">

                    <div class="img-box">
                        <img src="{{ asset('storage/'. $product->image ) }}" alt="">
                    </div>
                    <div class="detail-box">
                        <h6>{{$product->title}}</h6>
                        <h6>Price<span>₹{{$product->price}}</span></h6>
                    </div>
                    <div style="padding: 15px;">
                        <a href="{{url('product_details',$product->slug)}}" class="btn btn-danger">Details</a>
                        <button class="btn btn-success add-to-cart" data-product-id="{{$product->id}}">Add to Cart</button>
                        <div class="mt-2 cart-message-small"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script>
          $(document).on("click", ".add-to-cart", function (e) {
        // Prevent form submission
        e.preventDefault();
        const productId = $(this).data("product-id");
        const messageDiv = $("#cart-message");

        $.ajax({
            url: `/add_cart/${productId}`,
            type: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
            beforeSend: function () {
                messageDiv
                    .removeClass("text-success text-danger")
                    .html(
                        '<div class="spinner-border spinner-border-sm" role="status"></div> Adding to cart...'
                    );
            },
            success: function (response) {
                if (response.success) {
                    // Display success message
                    messageDiv
                        .removeClass("text-danger")
                        .addClass("text-success")
                        .html(
                            '<div class="alert alert-success" role="alert">' +
                                response.message +
                                "</div>"
                        );
                    // Update cart count in the navigation
                    $(".cart_count").text(response.cartCount);

                    // Also show a floating notification that will be visible on any page
                    showFloatingNotification(response.message, "success");

                    // Clear message after 3 seconds
                    setTimeout(function () {
                        messageDiv.html("");
                    }, 3000);
                } else {
                    messageDiv
                        .removeClass("text-success")
                        .addClass("text-danger")
                        .html(
                            '<div class="alert alert-danger" role="alert">' +
                                response.message +
                                "</div>"
                        );
                }
            },
            error: function (xhr) {
                const response = xhr.responseJSON;
                const errorMessage =
                    response && response.message
                        ? response.message
                        : "Error adding product to cart. Please try again.";
                messageDiv
                    .removeClass("text-success")
                    .addClass("text-danger")
                    .html(
                        '<div class="alert alert-danger" role="alert">' +
                            errorMessage +
                            "</div>"
                    );

                // Redirect to login if unauthorized
                if (xhr.status === 401) {
                    window.location.href = "/login";
                }
            },
        });
    });
        </script>
</section>
