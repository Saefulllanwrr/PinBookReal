<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinBook Katalog</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body
    class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 font-poppins transition-colors duration-300">

    <!-- Navbar -->
    <x-navbar class="fixed top-0 left-0 w-full bg-white dark:bg-gray-800 shadow-lg z-50"></x-navbar>

    <!-- Spasi untuk Navbar -->
    <div class="h-16"></div>

    <!-- Form Pencarian & Filter -->
    <div
        class="container mx-auto px-4 pb-6 flex justify-center items-center flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <form action="{{ route('search') }}" method="GET" class="flex items-center w-full max-w-3xl space-x-4">
            <input type="text" name="query" placeholder="Cari buku..."
                class="flex-1 h-14 px-6 rounded-2xl border border-slate-300 dark:border-gray-600 shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/50 focus:border-blue-500 transition duration-300 text-slate-700 dark:text-white dark:bg-gray-700 placeholder-slate-400 dark:placeholder-gray-400"
                aria-label="Cari buku">
            <button type="submit"
                class="h-14 px-8 bg-[#0B192C] dark:bg-[#FF6500] text-white rounded-2xl font-semibold shadow-lg hover:bg-[#FF6500] dark:hover:bg-[#E55A00] transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center">
                <i class="fas fa-search mr-2"></i> Cari
            </button>
        </form>
        <select
            class="h-14 px-4 rounded-2xl border border-slate-300 dark:border-gray-600 shadow-lg focus:outline-none text-slate-700 dark:text-white dark:bg-gray-700"
            aria-label="Filter Kategori" onchange="this.form.submit()" name="kategori">
            <option value="">Semua Kategori</option>
            @foreach ($kategori as $kategoris)
                <option value="{{ $kategoris->id }}" {{ request('kategori') == $kategoris->id ? 'selected' : '' }}>
                    {{ $kategoris->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Hasil Pencarian -->
    <div class="container mx-auto px-4 mt-8">
        @if ($books->isEmpty())
            <div class="text-center text-slate-500 dark:text-gray-400 text-xl font-medium py-12">
                <i class="fas fa-book-open mr-2"></i> Tidak ada buku yang ditemukan.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($books as $book)
                    <div class="bg-white dark:bg-gray-700 shadow-2xl rounded-3xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-3xl duration-300"
                        onclick="openModal({{ $book->id }})">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->judul }}"
                            class="w-full h-72 object-cover rounded-t-3xl" loading="lazy">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white truncate">{{ $book->judul }}
                            </h3>
                            <p class="text-slate-600 dark:text-gray-300 text-sm mt-2 flex items-center">
                                <i class="fas fa-user-edit mr-2"></i> Penulis: {{ $book->penulis }}
                            </p>
                            <p class="text-slate-600 dark:text-gray-300 text-sm flex items-center">
                                <i class="fas fa-building mr-2"></i> Penerbit: {{ $book->penerbit }}
                            </p>
                            <a href="{{ route('peminjaman', ['id' => $book->id]) }}">
                                <button
                                    class="w-full bg-[#FF6500] text-white py-3 mt-6 rounded-xl font-bold hover:bg-[#E55A00] transition duration-300 transform hover:scale-105 flex items-center justify-center">
                                    <i class="fas fa-book-reader mr-2"></i> Pinjam Buku
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $books->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail Buku -->
    <div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-3xl p-6 relative">
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-4" id="modalTitle"></h2>
            <p class="text-slate-600 dark:text-gray-300" id="modalContent"></p>
        </div>
    </div>

    <script>
        // Membuka Modal
        function openModal(bookId) {
            fetch(`/books/detail/${bookId}`)
                .then(response => response.json())
                .then(data => {
                    // Isi modal dengan data dari API
                    document.getElementById('modalTitle').innerText = data.judul;
                    document.getElementById('modalContent').innerHTML = `
                        <img src="${data.cover}" alt="Cover ${data.judul}" class="w-full h-72 object-cover rounded-xl mb-4">
                        <p><strong>Penulis:</strong> ${data.penulis}</p>
                        <p><strong>Penerbit:</strong> ${data.penerbit}</p>
                        <p><strong>Deskripsi:</strong> ${data.deskripsi}</p>
                    `;
                    // Tampilkan modal
                    document.getElementById('modalDetail').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Menutup Modal
        function closeModal() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        // Menutup Modal dengan Klik di Luar Konten
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('modalDetail');
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
</body>

</html>
