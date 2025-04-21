<!DOCTYPE html>
<html>

<head>
    <title>Password Anda Telah Direset</title>
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

        .password-box {
            background-color: #f1f1f1;
            padding: 10px;
            margin: 10px 0;
            font-family: monospace;
            font-size: 1.2em;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Reset Password - {{ config('app.name') }}</h2>
        </div>

        <div class="content">
            <p>Halo {{ $user->name }},</p>

            <p>Password akun Anda telah direset oleh administrator. Berikut adalah password baru Anda:</p>

            <div class="password-box">
                {{ $newPassword }}
            </div>

            <p>Untuk keamanan, kami sarankan Anda:</p>
            <ol>
                <li>Login menggunakan password di atas</li>
                <li>Segera ganti password Anda di halaman profil</li>
                <li>Jangan berikan password ini kepada siapapun</li>
            </ol>

            <p>Jika Anda tidak melakukan permintaan reset ini, segera hubungi administrator.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
