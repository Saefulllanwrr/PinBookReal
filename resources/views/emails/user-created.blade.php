<!DOCTYPE html>
<html>

<head>
    <title>Akun Anda Telah Dibuat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .footer {
            margin-top: 20px;
            padding: 10px;
            text-align: center;
            font-size: 0.8em;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Selamat Datang di {{ config('app.name') }}</h2>
        </div>

        <div class="content">
            <p>Halo {{ $user->name }},</p>

            <p>Akun Anda telah berhasil dibuat dengan detail berikut:</p>

            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Username:</strong> {{ $user->username }}</li>
                @if ($password)
                    <li><strong>Password:</strong> {{ $password }}</li>
                @endif
            </ul>

            <p>Silakan login menggunakan kredensial di atas.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
