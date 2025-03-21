$(document).ready(function () {
    // Add to cart button click handler
    $(".add-to-cart").click(function (e) {
        e.preventDefault();
        const productId = $(this).data("product-id");
        const button = $(this);
        // Check if we're on the product details page or home page
        const messageDiv = $("#cart-message").length
            ? $("#cart-message")
            : button.siblings(".cart-message-small");

        // Disable the button while processing
        button.prop("disabled", true);

        $.ajax({
            url: `/add_cart/${productId}`,
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    // Show success message
                    messageDiv.html(
                        `<div class="alert alert-success">${response.message}</div>`
                    );

                    // Update cart count in header
                    if (response.cartCount !== undefined) {
                        $("#cart-count").text(response.cartCount);
                    } else {
                        const currentCount =
                            parseInt($("#cart-count").text()) || 0;
                        $("#cart-count").text(currentCount + 1);
                    }
                } else {
                    // Handle error in success response
                    messageDiv.html(
                        `<div class="alert alert-danger">${
                            response.message || "Error adding to cart"
                        }</div>`
                    );
                }

                // Clear message after 2 seconds
                setTimeout(() => {
                    messageDiv.html("");
                }, 2000);
            },
            error: function (xhr) {
                console.log("Error:", xhr); // For debugging
                let errorMessage = "Error adding to cart";

                if (xhr.status === 401) {
                    errorMessage = "Please login first";
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                messageDiv.html(
                    `<div class="alert alert-danger">${errorMessage}</div>`
                );

                setTimeout(() => {
                    messageDiv.html("");
                }, 2000);
            },
            complete: function () {
                // Re-enable the button after request completes
                button.prop("disabled", false);
            },
        });
    });
});
