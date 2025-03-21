// Function to show floating notification
function showFloatingNotification(message, type) {
    // Create notification element if it doesn't exist
    if ($("#floating-notification").length === 0) {
        $("body").append(
            '<div id="floating-notification" class="position-fixed" style="top: 20px; right: 20px; z-index: 9999; max-width: 350px;"></div>'
        );
    }

    // Create notification content
    const notificationId = "notification-" + Date.now();
    const notificationHtml = `
        <div id="${notificationId}" class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;

    // Add notification to container
    $("#floating-notification").append(notificationHtml);

    // Auto remove after 3 seconds
    setTimeout(function () {
        $(`#${notificationId}`).fadeOut(function () {
            $(this).remove();
        });
    }, 3000);
}

$(document).ready(function () {
    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Handle remove from cart
    $(".btn-remove").click(function () {
        var cartId = $(this).data("cart-id");
        if (
            confirm("Are you sure you want to remove this item from your cart?")
        ) {
            $.ajax({
                url: "/remove_cart/" + cartId,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert("Error removing item from cart");
                    }
                },
                error: function () {
                    alert("Error removing item from cart");
                },
            });
        }
    });

    // Handle order form submission
    $("#order-form").submit(function (e) {
        e.preventDefault();

        // Get form data
        var formData = {
            name: $("#name").val(),
            phone: $("#phone").val(),
            address: $("#address").val(),
        };
        console.log(formData);

        // Validate form
        if (!formData.name || !formData.phone || !formData.address) {
            $("#cart-message")
                .html(
                    '<div class="alert alert-danger">Please fill in all required fields.</div>'
                )
                .show();
            return;
        }

        // Disable submit button and show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        submitBtn
            .prop("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...'
            );

        // Send AJAX request
        $.ajax({
            url: "/confirm_order",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Show success message
                    $("#cart-message")
                        .html(
                            '<div class="alert alert-success">' +
                                response.message +
                                "</div>"
                        )
                        .show();

                    // Redirect to invoice page after a short delay
                    setTimeout(function () {
                        window.location.href = response.redirect_url;
                    }, 1500);
                } else {
                    // Show error message
                    $("#cart-message")
                        .html(
                            '<div class="alert alert-danger">' +
                                response.message +
                                "</div>"
                        )
                        .show();
                }
            },
            error: function (xhr) {
                var errorMessage =
                    "An error occurred while placing your order. Please try again.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $("#cart-message")
                    .html(
                        '<div class="alert alert-danger">' +
                            errorMessage +
                            "</div>"
                    )
                    .show();
            },
            complete: function () {
                // Re-enable submit button
                submitBtn.prop("disabled", false).text("Place Order");
            },
        });
    });

    // Function to update cart total
    function updateCartTotal() {
        let total = 0;
        $("table tr:not(:first)").each(function () {
            const price = parseFloat($(this).find("td:eq(1)").text()) || 0;
            const quantity = parseInt($(this).find("td:eq(2)").text()) || 0;
            total += price * quantity;
        });
        $(".cart_value h3").text("Total Value of Cart is : " + total);
    }

    // Handle add to cart button click
    $(document).on("click", ".add-to-cart", function (e) {
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
});
