<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konfirmasi Peminjaman</title>
    @vite('resources/css/app.css')
   
</head>

<body class="bg-gradient-to-r from-blue-50 to-purple-50 flex flex-col items-center min-h-screen">

    {{-- Header --}}
    <x-navbar></x-navbar>

    {{-- Konten --}}
    <main class="flex flex-col md:flex-row items-center justify-center mt-12 px-8 gap-8 w-full max-w-5xl">

        {{-- Kartu Buku --}}
        <div class="card bg-white shadow-lg rounded-xl p-6 w-80 mb-8 md:mb-0 transform transition-all">
            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}"
                class="rounded-lg mb-4 w-full h-64 object-cover">
            <h2 class="text-xl font-bold text-center text-gray-800">{{ $book->judul }}</h2>
        </div>

        {{-- Konfirmasi Peminjaman --}}
        <div class="card bg-white shadow-lg rounded-xl p-8 w-full md:w-96 transform transition-all">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Konfirmasi Peminjaman Buku</h2>
            <div class="space-y-4 text-gray-700">
                <p><span class="font-medium">Judul:</span> {{ $book->judul }}</p>
                <p><span class="font-medium">Kategori:</span>
                    {{ $book->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</p>
                <p><span class="font-medium">Penulis:</span> {{ $book->penulis }}</p>
                <p><span class="font-medium">Diterbitkan:</span> {{ $book->diterbitkan ?? '-' }}</p>
                <p><span class="font-medium">Dipinjam:</span> <span
                        id="tanggal_pinjam">{{ \Carbon\Carbon::today()->toDateString() }}</span></p>
                <p><span class="font-medium">Dikembalikan:</span> <span
                        id="tanggal_kembali">{{ \Carbon\Carbon::today()->addDays(2)->toDateString() }}</span></p>
                <p class="text-sm text-red-600 mt-4">Batas pengembalian buku maksimal 2 hari setelah dipinjam!</p>
            </div>
            @if (Auth::check())
                <form action="{{ route('pinjam.store') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" name="buku_id" value="{{ $book->id }}">
                    <button type="submit" class="btn-primary w-full">Pinjam Buku</button>
                </form>
            @else
                <a href="{{ route('login') }}" onclick="alert('Anda harus login untuk meminjam buku!')"
                    class="block mt-6">
                    <button class="btn-secondary w-full">Login untuk Meminjam</button>
                </a>
            @endif
        </div>

    </main>

</body>

</html>
