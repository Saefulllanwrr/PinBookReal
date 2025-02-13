<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>PinBook - Register</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-slate-900 to-[#0B192C] flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-[#0B192C] rounded-2xl shadow-2xl p-6">
        <!-- Header -->
        <div class="text-center">
            <h1 class="font-bold text-3xl text-slate-200">
                Pin<span class="text-[#FF6500]">Book</span>
            </h1>
            <p class="font-medium text-sm text-slate-400 mt-1">
                Daftar akun baru!
            </p>
        </div>

        <!-- Menampilkan pesan error -->
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-500 text-sm p-3 rounded-lg mt-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Registrasi -->
        <form class="mt-4" action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name Input -->
            <div class="mb-3">
                <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Nama :</label>
                <input type="text" id="name" name="name" placeholder="Nama" value="{{ old('name') }}"
                    required
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username Input -->
            <div class="mb-3">
                <label for="username" class="block text-sm font-medium text-slate-300 mb-1">Username :</label>
                <input type="text" id="username" name="username" placeholder="Username"
                    value="{{ old('username') }}" required
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
                @error('username')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email :</label>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}"
                    required
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Password :</label>
                <input type="password" id="password" name="password" placeholder="Password" required
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-3">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1">Konfirmasi
                    Password :</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Konfirmasi Password" required
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
            </div>

            <!-- Profile Picture Input -->
            <div class="mb-4">
                <label for="profile" class="block text-sm font-medium text-slate-300 mb-1">Foto Profil (Opsional)
                    :</label>
                <input type="file" id="profile" name="profile"
                    class="w-full bg-slate-800 border border-slate-700 text-slate-200 text-sm rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-[#FF6500] transition duration-200">
                @error('profile')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Link ke Login -->
            <div class="flex items-center justify-end mt-4 mb-4">
                <a href="{{ route('login') }}"
                    class="text-sm text-[#FF6500] hover:text-slate-300 transition duration-200">
                    Sudah punya akun?
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-[#FF6500] text-white font-medium rounded-lg text-sm py-2.5 text-center hover:bg-[#E55A00] transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#FF6500] focus:ring-offset-2">
                Daftar
            </button>
        </form>
    </div>
</body>

</html>
