$(document).ready(function() {
    // Login form validation
    $('#login-form').validate({
        rules: {
            loginUsername: {
                required: true,
                minlength: 3
            },
            loginPassword: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            loginUsername: {
                required: 'Please enter your username',
                minlength: 'Username must be at least 3 characters'
            },
            loginPassword: {
                required: 'Please enter your password',
                minlength: 'Password must be at least 6 characters'
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    // Registration form validation
    $('#register-form').validate({
        rules: {
            registerUsername: {
                required: true,
                minlength: 3
            },
            registerEmail: {
                required: true,
                email: true
            },
            registerPassword: {
                required: true,
                minlength: 6
            },
            registerAgree: {
                required: true
            }
        },
        messages: {
            registerUsername: {
                required: 'Please enter a username',
                minlength: 'Username must be at least 3 characters'
            },
            registerEmail: {
                required: 'Please enter your email address',
                email: 'Please enter a valid email address'
            },
            registerPassword: {
                required: 'Please enter a password',
                minlength: 'Password must be at least 6 characters'
            },
            registerAgree: {
                required: 'You must agree to the terms and conditions'
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });
});
