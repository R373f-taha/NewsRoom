{{-- resources/views/emails/welcome.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 30px; }
        .header { background: #b45309; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .button { background: #eab308; color: #333; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold; }
        .footer { text-align: center; padding: 20px; color: #888; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Welcome, {{ $user->name }}!</h1>
        </div>
        <div class="content">
            <p>Thank you for joining us! 🎈</p>
            <p>We are thrilled to have you as a member of our community.</p>
            <p>You can now:</p>
            <ul>
                <li>📝 Read exclusive articles</li>
                <li>💬 Comment and engage with others</li>
                <li>🔔 Subscribe to notifications</li>
            </ul>
            <p style="text-align: center;">
                <a href="{{ url('/dashboard') }}" class="button">🚀 Get Started</a>
            </p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
