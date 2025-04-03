<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Giftos</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.8;
            color: #2c3e50;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px 20px;
            background-color: #f5f6fa;
        }

        .header {
            background: linear-gradient(135deg, #f5426c 0%, #f83a3a 100%);
            color: white;
            padding: 35px 20px;
            text-align: center;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .content {
            background-color: white;
            padding: 40px 30px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .content p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .content ul {
            padding-left: 20px;
            margin-bottom: 25px;
        }

        .content li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .button {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #f5426c 0%, #f83a3a 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin-top: 25px;
            margin-bottom: 10px;
            text-align: center;
            transition: transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            line-height: 1.6;
        }

        .footer p {
            margin: 8px 0;
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