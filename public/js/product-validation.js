$(document).ready(function () {
    $.validator.addMethod(
        "filesize",
        function (value, element, param) {
            return (
                this.optional(element) ||
                element.files[0].size <= param * 1024 * 1024
            );
        },
        "File size must be less than {0} MB"
    );

    $("#product-form").validate({
        errorClass: "text-red-500 text-sm mt-1",
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            element
                .closest(".mb-6")
                .find(".error-message")
                .removeClass("hidden")
                .text(error.text());
        },
        success: function (label, element) {
            $(element)
                .closest(".mb-6")
                .find(".error-message")
                .addClass("hidden");
        },
        rules: {
            title: {
                required: true,
                minlength: 3,
                maxlength: 100,
            },
            description: {
                required: true,
                minlength: 10,
                maxlength: 1000,
            },
            price: {
                required: true,
                number: true,
                min: 0.01,
                max: 999999.99,
            },
            qty: {
                required: true,
                digits: true,
                min: 1,
                max: 9999,
            },
            category: {
                required: true,
            },
            image: {
                required: true,
                accept: "image/jpeg,image/png,image/gif,image/webp",
                filesize: 5,
            },
        },
        messages: {
            title: {
                required: "Please enter a product title",
                minlength: "Title must be at least 3 characters long",
                maxlength: "Title cannot exceed 100 characters",
            },
            description: {
                required: "Please enter a product description",
                minlength: "Description must be at least 10 characters long",
                maxlength: "Description cannot exceed 1000 characters",
            },
            price: {
                required: "Please enter a product price",
                number: "Please enter a valid price",
                min: "Price must be at least $0.01",
                max: "Price cannot exceed $999,999.99",
            },
            qty: {
                required: "Please enter product quantity",
                digits: "Please enter a valid quantity",
                min: "Quantity must be at least 1",
                max: "Quantity cannot exceed 9999",
            },
            category: {
                required: "Please select a category",
            },
            image: {
                required: "Please select a product image",
                accept: "Please select a valid image file (JPEG, PNG, GIF, or WebP)",
                filesize: "Image size must be less than 5 MB",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
        highlight: function (element) {
            $(element).addClass("border-red-500").removeClass("border-white");
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-500").addClass("border-white");
        },
    });
});