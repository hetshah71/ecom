<x-mail::message>
<div style="text-align: center; margin-bottom: 30px;">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 200px;">
</div>

<h1 style="text-align: center; color: #2d3748; margin-bottom: 20px;">Verify Your Email Address</h1>

<p style="color: #4a5568; margin-bottom: 20px; text-align: center;">
    Hi {{ $user->name }},
</p>

<p style="color: #4a5568; margin-bottom: 20px; text-align: center;">
    Thank you for registering with us! Please click the button below to verify your email address and activate your account.
</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $url }}" style="background-color: #4f46e5; color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-block;">
        Verify Email Address
    </a>
</div>

<p style="color: #718096; font-size: 14px; text-align: center;">
    If you did not create an account, no further action is required.
</p>

<p style="color: #718096; font-size: 14px; text-align: center; margin-top: 20px;">
    If you're having trouble clicking the button, copy and paste this URL into your browser:
    <br>
    <span style="color: #4f46e5;">{{ $url }}</span>
</p>

<p style="color: #718096; font-size: 14px; text-align: center; margin-top: 30px;">
    Thanks,<br>
    {{ config('app.name') }}
</p>
</x-mail::message>