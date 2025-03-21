<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Giftos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Welcome to Giftos!</h1>
    </div>

    <div class="content">
        <h2>Hello {{ $user->name }},</h2>

        <p>Welcome to Giftos! We're thrilled to have you as part of our community.</p>

        <p>At Giftos, you'll find:</p>
        <ul>
            <li>A wide selection of unique gifts</li>
            <li>Special offers and discounts</li>
            <li>Easy shopping experience</li>
            <li>Secure payment options</li>
        </ul>

        <p>Start exploring our collection today!</p>

        <a href="{{ url('/shop') }}" class="button">Start Shopping</a>

        <p>If you have any questions, feel free to contact our support team.</p>

        <p>Best regards,<br>The Giftos Team</p>
    </div>

    <div class="footer">
        <p>This email was sent to {{ $user->email }}. If you didn't create this account, please ignore this email.</p>
        <p>&copy; {{ date('Y') }} Giftos. All rights reserved.</p>
    </div>
</body>

</html>