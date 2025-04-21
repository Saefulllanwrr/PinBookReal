<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinBook Katalog</title>
    @vite(['resources/css/pagination.css', 'resources/css/app.css', 'resources/css/hover.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body
    class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 font-poppins transition-colors duration-300">
    <!-- Navbar -->
    <x-navbar class="sticky top-0 left-0 w-full bg-white dark:bg-slate-800 shadow-md z-50"></x-navbar>

    <div class="pt-24"></div>

    <!-- Form Pencarian & Filter -->
    <div class="container mx-auto px-4 pb-6 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
        <form action="{{ route('katalogBuku') }}" method="GET" class="flex w-full max-w-3xl">
            <div class="relative flex-1">
                <input type="text" name="query" placeholder="Cari buku..."
                    class="w-full h-14 pl-12 pr-4 rounded-2xl border border-slate-300 dark:border-slate-600 shadow-lg focus:ring-2 focus:ring-blue-500 text-slate-700 dark:text-white dark:bg-slate-700 placeholder-slate-400">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
            </div>
            <button type="submit"
                class="ml-4 h-14 px-6 bg-[#FF6500] text-white rounded-2xl font-semibold shadow-lg hover:bg-[#E55A00] transition duration-300">
                Cari
            </button>
        </form>
        <form action="{{ route('katalogBuku') }}" method="GET">
            <select
                class="h-14 px-4 rounded-2xl border border-slate-300 dark:border-slate-600 shadow-lg text-slate-700 dark:text-white dark:bg-slate-700"
                onchange="this.form.submit()" name="kategori">
                <option value="">Kategori</option>
                @foreach ($kategori as $kategoris)
                    <option value="{{ $kategoris->id }}" {{ request('kategori') == $kategoris->id ? 'selected' : '' }}>
                        {{ $kategoris->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Buku Terpopuler -->
    <div class="container mx-auto px-4 mt-8">
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4">Buku Terpopuler</h3>
        @if ($books->isEmpty())
            <div class="text-center text-slate-500 dark:text-slate-400 text-sm font-medium py-12">
                <i class="fas fa-book-open mr-2"></i> Belum ada buku populer.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($favoriteBooks as $book)
                    <div
                        class="bg-white dark:bg-slate-700 shadow-2xl rounded-3xl overflow-hidden hover:shadow-3xl duration-300">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->judul }}"
                                class="w-full h-72 object-cover rounded-t-3xl">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer"
                                onclick="openModal({{ $book->id }})">
                                <span class="text-white text-xl font-bold font-poppins">Detail</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white truncate">{{ $book->judul }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-300 text-sm mt-2 flex items-center">
                                <i class="fas fa-user-edit mr-2"></i> Penulis: {{ $book->penulis }}
                            </p>
                            <p class="text-slate-600 dark:text-slate-300 text-sm flex items-center">
                                <i class="fas fa-building mr-2"></i> Penerbit: {{ $book->penerbit }}
                            </p>
                            <p class="text-slate-600 dark:text-slate-300 text-sm flex items-center">
                                <i class="fas fa-tag mr-2"></i> Kategori: {{ $book->kategori->nama_kategori }}
                            </p>
                            <p class="text-slate-600 dark:text-slate-300 text-sm"> {{ $book->borrow_count }} kali di
                                pinjam</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Buku Pilihan -->
    <div class="container mx-auto px-4 mt-8">
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4">Buku Pilihan</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($books as $book)
                <div class="bg-white dark:bg-slate-700 shadow-lg rounded-xl overflow-hidden hover:shadow-xl transition">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->judul }}"
                            class="w-full h-64 object-cover rounded-t-xl">
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer"
                            onclick="openModal({{ $book->id }})">
                            <span class="text-white text-xl font-bold">Detail</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white truncate">{{ $book->judul }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Penulis: {{ $book->penulis }}</p>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Kategori:
                            {{ $book->kategori->nama_kategori }}</p>
                    </div>
                    <div class="p-4 flex gap-2">
                        <a href="{{ route('peminjaman', ['id' => $book->id]) }}" class="w-full">
                            <button
                                class="w-full bg-[#FF6500] text-white py-2 rounded-lg font-bold hover:bg-[#E55A00] transition">
                                Pinjam Buku
                            </button>
                        </a>
                        <form action="{{ route('favorite.store', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-10 h-10 bg-gray-200 dark:bg-gray-700 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="my-8 flex justify-center">
            {{ $books->links('vendor.pagination.custom') }}
        </div>
    </div>

    <!-- Modal Detail Buku -->
    <div id="modalDetail"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg w-full max-w-3xl p-6 relative">
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-slate-500 dark:text-slate-300 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4" id="modalTitle"></h2>
            <p class="text-slate-600 dark:text-slate-300" id="modalContent"></p>
        </div>
    </div>

    <script>
        function openModal(bookId) {
            fetch(`/books/detail/${bookId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').innerText = data.judul;
                    document.getElementById('modalContent').innerHTML = `
                        <img src="${data.cover}" alt="Cover ${data.judul}" class="w-full h-64 object-cover rounded-xl mb-4">
                        <p><strong>Penulis:</strong> ${data.penulis}</p>
                        <p><strong>Penerbit:</strong> ${data.penerbit}</p>
                        <p><strong>Kategori:</strong> ${data.nama_kategori}</p>
                        <p><strong>Deskripsi:</strong> ${data.deskripsi}</p>
                    `;
                    document.getElementById('modalDetail').classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        function closeModal() {
            document.getElementById('modalDetail').classList.add('hidden');
        }
    </script>
</body>

</html>
