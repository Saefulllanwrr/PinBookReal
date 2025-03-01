<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <x-navbar></x-navbar>
    <!-- Tambahkan margin-top (mt-16) atau padding-top (pt-16) ke div utama -->
    <div class="min-h-screen flex justify-center items-center p-4 pt-16"> <!-- Perubahan di sini -->
        <div class="bg-white shadow-2xl rounded-lg p-8 w-full max-w-2xl">
            <div class="flex flex-col items-center">
                <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="w-16 h-16 rounded-full"
                    alt="Avatar">

                <h2 class="text-3xl font-bold text-gray-800">{{ $users->name }}</h2>
                <p class="text-gray-600 mt-2">{{ $users->email }}</p>
                <button
                    class="mt-6 bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300 transform hover:scale-110">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </button>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Akun</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-user text-blue-500 mr-2"></i>
                            <span class="text-gray-600">Nama Lengkap:</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $users->name }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-500 mr-2"></i>
                            <span class="text-gray-600">Email:</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $users->email }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-phone text-blue-500 mr-2"></i>
                            <span class="text-gray-600">Nomor Telepon:</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $users->no_telepon ?? 'N/A' }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                            <span class="text-gray-600">Alamat:</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $users->address ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300 transform hover:scale-110">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
