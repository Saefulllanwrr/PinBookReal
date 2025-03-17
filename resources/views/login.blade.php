<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinBook - Login</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Tailwind CSS -->

    @vite('resources/css/app.css')
</head>

<body
    class="font-poppins bg-gradient-to-r from-slate-900 to-[#0B192C] flex items-center justify-center min-h-screen p-4">


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
                <label for="username" class="block text-sm font-medium text-slate-300 mb-2">Email atau Username</label>
                <input type="text" id="username" name="username" placeholder="Masukan email atau username..."
                    required
                    class="w-full bg-[#0B192C] border border-slate-400 text-slate-500 text-sm rounded-lg p-2.5
                    focus:outline-none focus:ring-2 focus:ring-[#FF6500] focus:text-white transition duration-200">
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukan password anda..." required
                    class="w-full bg-[#0B192C] border border-slate-400 text-slate-500 text-sm rounded-lg p-2.5
                    focus:outline-none focus:ring-2 focus:ring-[#FF6500] focus:text-white transition duration-200">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember"
                        class="w-4 h-4 text-[#FF6500] bg-slate-800 border-slate-700 rounded"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember"
                        class="ml-2 text-sm text-slate-400 hover:text-slate-300 transition duration-200">
                        Ingat Saya
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-[#FF6500] text-white font-medium rounded-lg text-sm py-2.5 text-center
                hover:bg-[#E55A00] active:scale-95 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF6500] focus:ring-offset-2">
                Login
            </button>
        </form>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>
