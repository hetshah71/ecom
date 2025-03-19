document.addEventListener("DOMContentLoaded", function () {
    // Initialize all modals
    var modals = document.querySelectorAll(".modal");
    modals.forEach(function (modal) {
        new bootstrap.Modal(modal);
    });

    // Fix modal trigger buttons
    var removeButtons = document.querySelectorAll(".btn-remove");
    removeButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var targetModal = this.getAttribute("data-bs-target");
            var modal = new bootstrap.Modal(
                document.querySelector(targetModal)
            );
            modal.show();
        });
    });

    // Handle form submissions
    var removeForms = document.querySelectorAll(".modal form");
    removeForms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            fetch(this.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    _method: "DELETE",
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(
                            this.closest(".modal")
                        );
                        modal.hide();

                        // Remove the cart item row
                        var cartItemRow = this.closest("tr");
                        cartItemRow.remove();

                        // Update cart total
                        updateCartTotal();
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    });
});

function updateCartTotal() {
    var prices = document.querySelectorAll("td:nth-child(2)");
    var total = 0;

    prices.forEach(function (price) {
        total += parseFloat(price.textContent);
    });

    document.querySelector(".cart_value h3").textContent =
        "Total Value of Cart is : " + total;
}
