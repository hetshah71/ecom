$(document).ready(function () {
    // Common validation rules
    const commonRules = {
        name: {
            required: true,
            minlength: 3,
        },
        email: {
            required: true,
            email: true,
        },
        phone: {
            required: true,
            digits: true,
            minlength: 10,
            maxlength: 15,
        },
        address: {
            required: true,
            minlength: 10,
        },
        password: {
            required: true,
            minlength: 8,
        },
        password_confirmation: {
            required: true,
            equalTo: "#password",
        },
    };

    // Common error messages
    const commonMessages = {
        name: {
            required: "Please enter your name",
            minlength: "Name must be at least 3 characters long",
        },
        email: {
            required: "Please enter your email address",
            email: "Please enter a valid email address",
        },
        phone: {
            required: "Please enter your phone number",
            digits: "Please enter only digits",
            minlength: "Phone number must be at least 10 digits",
            maxlength: "Phone number cannot be more than 15 digits",
        },
        address: {
            required: "Please enter your address",
            minlength: "Address must be at least 10 characters long",
        },
        password: {
            required: "Please enter a password",
            minlength: "Password must be at least 8 characters long",
        },
        password_confirmation: {
            required: "Please confirm your password",
            equalTo: "Passwords do not match",
        },
    };

    // Registration form validation
    $("#register-form").validate({
        rules: commonRules,
        messages: commonMessages,
        errorElement: "span",
        errorClass: "text-red-500 text-sm",
        highlight: function (element) {
            $(element).addClass("border-red-500");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-500");
        },
    });

    // Login form validation
    $("#login-form").validate({
        rules: {
            email: commonRules.email,
            password: {
                required: true,
            },
        },
        messages: {
            email: commonMessages.email,
            password: {
                required: "Please enter your password",
            },
        },
        errorElement: "span",
        errorClass: "text-red-500 text-sm",
        highlight: function (element) {
            $(element).addClass("border-red-500");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-500");
        },
    });

    // Admin product form validation
    $("#product-form").validate({
        rules: {
            title: {
                required: true,
                minlength: 3,
            },
            description: {
                required: true,
                minlength: 10,
            },
            price: {
                required: true,
                number: true,
                min: 0,
            },
            quantity: {
                required: true,
                digits: true,
                min: 0,
            },
            category: {
                required: true,
            },
            image: {
                required: true,
                accept: "image/*",
            },
        },
        messages: {
            title: {
                required: "Please enter product title",
                minlength: "Title must be at least 3 characters long",
            },
            description: {
                required: "Please enter product description",
                minlength: "Description must be at least 10 characters long",
            },
            price: {
                required: "Please enter product price",
                number: "Please enter a valid price",
                min: "Price cannot be negative",
            },
            quantity: {
                required: "Please enter product quantity",
                digits: "Please enter only digits",
                min: "Quantity cannot be negative",
            },
            category: {
                required: "Please select a category",
            },
            image: {
                required: "Please select a product image",
                accept: "Please select a valid image file",
            },
        },
        errorElement: "span",
        errorClass: "text-red-500 text-sm",
        highlight: function (element) {
            $(element).addClass("border-red-500");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-500");
        },
    });

    // Admin category form validation
    $("#category-form").validate({
        rules: {
            category_name: {
                required: true,
                minlength: 3,
            },
        },
        messages: {
            category_name: {
                required: "Please enter category name",
                minlength: "Category name must be at least 3 characters long",
            },
        },
        errorElement: "span",
        errorClass: "text-red-500 text-sm",
        highlight: function (element) {
            $(element).addClass("border-red-500");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-500");
        },
    });
});
