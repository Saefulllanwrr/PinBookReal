<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinBook Katalog</title>
    @vite('resources/css/app.css')

</head>

<body class="bg-gradient-to-r from-slate-50 to-blue-50 font-poppins">

    <!-- Navbar (Sticky) -->
    <x-navbar class="fixed top-0 left-0 w-full bg-white shadow-lg z-50"></x-navbar>

    <!-- Spasi untuk Navbar -->
    <div class="h-16"></div>

    <!-- Form Pencarian -->
    <div class="container mx-auto px-4 pb-6 flex justify-center">
        <form action="{{ route('search') }}" method="GET" class="flex items-center w-full max-w-3xl space-x-4">
            <input type="text" name="query" placeholder="Cari buku..."
                class="flex-1 h-14 px-6 rounded-2xl border border-slate-300 shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/50 focus:border-blue-500 transition duration-300 text-slate-700 placeholder-slate-400">
            <button type="submit"
                class="h-14 px-8 bg-[#0B192C] text-white rounded-2xl font-semibold shadow-lg hover:bg-[#FF6500] transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center">
                <span class="mr-2">🔍</span> Cari
            </button>
        </form>
    </div>

    <!-- Hasil Pencarian -->
    <div class="container mx-auto px-4 mt-8">
        @if ($books->isEmpty())
            <div class="text-center text-slate-500 text-xl font-medium py-12">
                📚 Tidak ada buku yang ditemukan.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($books as $book)
                    <div
                        class="bg-white shadow-2xl rounded-3xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-3xl duration-300">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}"
                            class="w-full h-72 object-cover rounded-t-3xl">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 truncate">{{ $book->judul }}</h3>
                            <p class="text-slate-600 text-sm mt-2 flex items-center">
                                <span class="mr-2">✍️</span> Penulis: {{ $book->penulis }}
                            </p>
                            <p class="text-slate-600 text-sm flex items-center">
                                <span class="mr-2">🏢</span> Penerbit: {{ $book->penerbit }}
                            </p>
                            <a href="{{ route('peminjaman', ['id' => $book->id]) }}">
                                <button
                                    class="w-full bg-[#FF6500] text-white py-3 mt-6 rounded-xl font-bold hover:bg-[#E55A00] transition duration-300 transform hover:scale-105 flex items-center justify-center">
                                    <span class="mr-2">📖</span> Pinjam Buku
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-[#0B192C] mt-12 py-8 text-white text-center">
        <p class="text-sm">© 2023 PinBook. All rights reserved.</p>
    </footer>

</body>

</html>
