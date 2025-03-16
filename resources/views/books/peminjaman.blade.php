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
        <!-- Menambahkan margin-top agar card tidak tertutup navbar -->

        <!-- Kartu Buku -->
        <div class="bg-white shadow-lg rounded-2xl p-6 w-80 md:w-96 transition-transform duration-300 hover:scale-105">
            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}"
                class="rounded-lg mb-4 w-full h-64 object-cover shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800">{{ $book->judul }}</h2>
        </div>

        <!-- Konfirmasi Peminjaman -->
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full md:w-96">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Konfirmasi Peminjaman</h2>

            <div class="space-y-4 text-gray-700">
                <p><span class="font-medium">Judul:</span> {{ $book->judul }}</p>
                <p><span class="font-medium">Kategori:</span>
                    {{ $book->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</p>
                <p><span class="font-medium">Penulis:</span> {{ $book->penulis }}</p>
                <p><span class="font-medium">Diterbitkan:</span> {{ $book->diterbitkan ?? '-' }}</p>
                <p><span class="font-medium">ISBN:</span> {{ $book->isbn }}</p>


            </div>

            @if (Auth::check())
                <div class="mt-2 flex gap-3">
                    <!-- Form Peminjaman -->
                    <form action="{{ route('peminjaman.store') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $book->id }}">
                        <input type="hidden" name="tanggal_pinjam" value="{{ now()->toDateString() }}">

                        <!-- Input tanggal kembali -->

                        <p class="font-thin pt-5 font-poppins text-red-600">Maksimal pengembalian buku 5 hari setelah
                            pinjam</p>
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

                </div>

                <!-- Tambahkan script Lucide -->
                <script>
                    lucide.createIcons();
                </script>
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

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        lucide.createIcons();
        $(document).ready(function() {
            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif
        });
    </script>
</body>

</html>
