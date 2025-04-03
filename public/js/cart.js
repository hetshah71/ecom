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

    // Remove any existing click handlers before adding new one
    $(".btn-remove").off("click");

    // Handle remove from cart
    $(".btn-remove").on("click", function () {
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
                        showFloatingNotification(response.message, "success");
                        // Update cart count in header
                        if (response.cartCount !== undefined) {
                            $("#cart-count").text(response.cartCount);
                        }
                        // Remove the row from the table
                        $(`.btn-remove[data-cart-id="${cartId}"]`)
                            .closest("tr")
                            .fadeOut(function () {
                                $(this).remove();
                                // Update cart UI without page reload
                                updateCartTotal();
                                // Show empty cart message if no items left
                                if ($(".cart-table tbody tr").length === 0) {
                                    $(".cart-table").replaceWith(
                                        '<div class="text-center"><h2>Your cart is empty!</h2><p>Add some products to your cart before placing an order.</p></div>'
                                    );
                                }
                            });
                    } else {
                        showFloatingNotification(
                            response.message || "Error removing item from cart",
                            "danger"
                        );
                    }
                },
                error: function (xhr) {
                    let errorMessage = "Error removing item from cart";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showFloatingNotification(errorMessage, "danger");
                },
            });
        }
    });

    // Handle order form submission

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
