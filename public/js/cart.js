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

                    // Redirect to invoice page
                    window.location.href = response.redirect_url;
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
  
});
