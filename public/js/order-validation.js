$(document).ready(function() {
    // Add error message container after each input
    $('#order-form input, #order-form textarea').after('<div class="error-message text-red-500 text-sm mt-1" style="display: none;"></div>');

    // Validate on form submission
    $('#order-form').on('submit', function(e) {
        let isValid = true;

        // Validate name
        const name = $('#name').val().trim();
        if (name.length < 2) {
            showError('#name', 'Name must be at least 2 characters long');
            isValid = false;
        } else {
            hideError('#name');
        }

        // Validate phone number (basic format: at least 10 digits)
        const phone = $('#phone').val().trim();
        const phoneRegex = /^\d{10,}$/;
        if (!phoneRegex.test(phone)) {
            showError('#phone', 'Please enter a valid phone number (at least 10 digits)');
            isValid = false;
        } else {
            hideError('#phone');
        }

        // Validate address
        const address = $('#address').val().trim();
        if (address.length === 0) {
            showError('#address', 'Please enter your delivery address');
            isValid = false;
        } else if (address.length < 10) {
            showError('#address', 'Please enter a complete delivery address (at least 10 characters)');
            isValid = false;
        } else {
            hideError('#address');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Real-time validation on input
    $('#order-form input, #order-form textarea').on('input', function() {
        const $input = $(this);
        const value = $input.val().trim();

        switch($input.attr('id')) {
            case 'name':
                if (value.length >= 2) {
                    hideError('#name');
                }
                break;
            case 'phone':
                if (/^\d{10,}$/.test(value)) {
                    hideError('#phone');
                }
                break;
            case 'address':
                if (value.length >= 10) {
                    hideError('#address');
                }
                break;
        }
    });

    // Helper functions
    function showError(selector, message) {
        $(selector).next('.error-message').text(message).show();
        $(selector).addClass('border-red-500');
    }

    function hideError(selector) {
        $(selector).next('.error-message').hide();
        $(selector).removeClass('border-red-500');
    }
});
