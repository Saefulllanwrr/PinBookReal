<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>PinBook - Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-slate-900 to-[#0B192C] flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-[#0B192C] rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="font-bold text-3xl text-slate-200">
                Pin<span class="text-[#FF6500]">Book</span>
            </h1>
            <p class="font-medium text-sm text-slate-400 mt-1">
                Masuk ke akun Anda!
            </p>
        </div>

        <!-- Form Login -->
        <form class="mt-6" action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Username Input -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-slate-300 mb-2">Username :</label>
                <input type="text" id="username" name="username" placeholder="Username" required
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password :</label>
                <input type="password" id="password" name="password" placeholder="Password" required
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
            </div>

            <!-- Remember Me & Buat Akun -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember"
                        class="w-4 h-4 text-[#FF6500] bg-slate-800 border-slate-700 rounded focus:ring-[#FF6500]">
                    <label for="remember"
                        class="ml-2 text-sm text-[#FF6500] hover:text-slate-300 transition duration-200">Ingat
                        Saya</label>
                </div>
                <a href="{{ route('show.register') }}"
                    class="text-sm text-[#FF6500] hover:text-slate-300 transition duration-200">
                    Buat Akun
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-[#FF6500] text-white font-medium rounded-lg text-sm py-2.5 text-center hover:bg-[#E55A00] transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF6500] focus:ring-offset-2">
                Login
            </button>
        </form>

        <!-- SweetAlert untuk Menampilkan Pesan Error -->
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#FF6500',
                });
            </script>
        @endif
    </div>
</body>

</html>
