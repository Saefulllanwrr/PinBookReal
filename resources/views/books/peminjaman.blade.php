<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konfirmasi Peminjaman</title>

    <!-- Toastr & jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-r from-blue-50 to-indigo-50 flex flex-col items-center min-h-screen">

    <!-- Navbar -->
    <x-navbar></x-navbar>

    <!-- Konten -->
    <main class="flex flex-col md:flex-row items-center justify-center px-8 gap-8 w-full max-w-5xl mt-24">
        <!-- Kartu Buku -->
        <div class="bg-white shadow-lg rounded-2xl p-6 w-80 md:w-96">
            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}"
                class="rounded-lg mb-4 w-full h-64 object-cover shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800">{{ $book->judul }}</h2>
        </div>

        <!-- Konfirmasi Peminjaman -->
        <div class="bg-white shadow-lg rounded-2xl p-6 w-80 md:w-96">
            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}"
                class="rounded-lg mb-4 w-full h-64 object-cover shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800">{{ $book->judul }}</h2>

            <!-- Button Tambahkan ke Favorit -->
            @if (Auth::check())
                <form action="{{ route('favorite.store', $book->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2 shadow-md">
                        <i data-lucide="heart" class="w-5 h-5"></i> Tambahkan ke Favorit
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" onclick="alert('Anda harus login untuk menambahkan buku ke favorit!')"
                    class="block mt-4">
                    <button
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2 shadow-md">
                        <i data-lucide="heart" class="w-5 h-5"></i> Login untuk Menambahkan ke Favorit
                    </button>
                </a>
            @endif

            <!-- Form Peminjaman -->
            @if (Auth::check())
                <form action="{{ route('peminjaman.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $book->id }}">
                    <input type="hidden" name="tanggal_pinjam" value="{{ now()->toDateString() }}">

                    <p class="font-thin pt-5 font-poppins text-red-600">Maksimal pengembalian buku 5 hari setelah pinjam
                    </p>
                    <label for="tanggal_kembali" class="block text-gray-700 font-medium mt-3">Tanggal
                        Pengembalian:</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                        class="w-full border rounded-lg px-4 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-500"
                        required>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 mt-4 rounded-lg transition flex items-center justify-center gap-2 shadow-md">
                        <i data-lucide="book-open" class="w-5 h-5"></i> Pinjam
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" onclick="alert('Anda harus login untuk meminjam buku!')"
                    class="block mt-6">
                    <button
                        class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2 shadow-md">
                        <i data-lucide="key" class="w-5 h-5"></i> Login untuk Meminjam
                    </button>
                </a>
            @endif
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
