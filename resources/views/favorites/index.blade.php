<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Favorit</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center">

    <!-- Navbar -->
    <x-navbar></x-navbar>

    <!-- Konten -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold text-gray-800 text-center mb-6">Daftar Favorit</h2>

        @if ($favorites->isEmpty())
            <p class="text-gray-600 text-center">Belum ada buku favorit. Yuk, tambahkan beberapa!</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($favorites as $favorite)
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden transform transition hover:scale-105">
                        <img src="{{ asset('storage/' . $favorite->book->cover) }}" alt="{{ $favorite->book->title }}"
                            class="w-full h-52 object-cover">

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $favorite->book->title }}</h3>
                            <p class="text-sm text-gray-600">Penulis: {{ $favorite->book->penulis }}</p>
                        </div>

                        <div class="p-4 flex justify-between items-center">
                            <a href="{{ route('peminjaman', $favorite->book->id) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                Lihat Buku
                            </a>

                            <form action="{{ route('favorites.destroy', $favorite->book_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                    ❌ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>

</html>
