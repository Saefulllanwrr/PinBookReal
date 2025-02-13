<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <x-navbar></x-navbar>
    <div class="min-h-screen flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <div class="flex flex-col items-center">
                <img src="https://via.placeholder.com/100" alt="Foto Profil" class="rounded-full mb-4 w-24 h-24">
                <h2 class="text-2xl font-semibold">{{ $users->name }}</h2>
                <p class="text-gray-600">{{ $users->email }}</p>
                <button
                    class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Edit
                    Profil</button>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Informasi Akun</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between">
                        <span class="text-gray-600">Nama Lengkap:</span>
                        <span class="font-semibold">{{ $users->name }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold">{{ $users->email }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Nomor Telepon:</span>
                        <span class="font-semibold">{{ $users->phone ?? 'N/A' }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Alamat:</span>
                        <span class="font-semibold">{{ $users->address ?? 'N/A' }}</span>
                    </li>
                </ul>
            </div>

            <div class="mt-6 text-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-300">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
