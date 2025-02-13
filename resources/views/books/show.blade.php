<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    @vite('resources/css/app.css') <!-- pastikan sudah mengonfigurasi Tailwind -->
</head>

<body class="bg-gray-50 font-sans">

    <div class="container mx-auto p-6">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-semibold text-gray-800">{{ $book->judul }}</h1>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col md:flex-row space-y-6 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <p class="text-lg text-gray-700"><strong class="text-gray-900">Penulis:</strong> {{ $book->penulis }}
                </p>
                <p class="text-lg text-gray-700"><strong class="text-gray-900">Penerbit:</strong> {{ $book->penerbit }}
                </p>
                <p class="text-lg text-gray-700"><strong class="text-gray-900">Diterbitkan:</strong>
                    {{ $book->diterbitkan }}</p>
                <p class="text-lg text-gray-700"><strong class="text-gray-900">Kategori:</strong>
                    <span class="text-blue-600">{{ $book->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</span>
                </p>
            </div>

            <div class="flex-shrink-0 w-full md:w-1/3">
                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Buku"
                    class="rounded-lg shadow-md max-w-full h-auto">
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('katalogBuku') }}"
                class="inline-block px-6 py-3 mt-4 bg-blue-500 text-white text-lg rounded-lg shadow-md hover:bg-blue-600 transition duration-200">
                Kembali ke Katalog Buku
            </a>
        </div>
    </div>

</body>

</html>
