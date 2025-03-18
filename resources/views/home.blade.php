<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <title>PinBook - Aplikasi Peminjaman Buku</title>

    @vite('resources/css/app.css')
</head>

<body>
    <!-- Header -->

    <x-navbar />
    <!-- Hero Section -->
    <main
        class="w-full h-[500px] md:h-[600px] bg-gradient-to-r from-[#0B192C] to-[#1A2A3C] dark:from-gray-800 dark:to-gray-900 relative overflow-hidden">
        <div class="container mx-auto h-full flex flex-col md:flex-row items-center justify-center px-6 md:px-12">

            <!-- Teks Sambutan -->
            <section class="w-[837px] ms-[59px] flex flex-col justify-center " data-aos="fade-right">
                <h2 class="font-poppins font-bold text-[40px] text-white pt-[70px]">
                    Selamat datang
                    @if (Auth::check())
                        {{ Auth::user()->name }}
                    @endif
                    di Website <span class="text-[#FF6500]">PinBook</span>
                </h2>
                <p class="font-poppins font-light text-[24px] text-[#D9D9D9] mt-1">
                    Aplikasi peminjaman buku yang praktis, cepat, dan menghemat waktu Anda.
                    Temukan buku favorit Anda, pinjam dengan mudah, dan nikmati pengalaman membaca tanpa ribet!
                </p>

                <!-- Form Pencarian -->
                <form class="mt-8 flex items-center gap-4" action="{{ route('search') }}" method="GET"
                    data-aos="fade-up">
                    <input type="text" name="query" placeholder="Cari buku berdasarkan judul, pengarang..."
                        class="w-[500px] h-[50px] px-4 rounded-[8px] text-[#0B192C] border-none font-poppins text-[16px] focus:outline-none"
                        aria-label="Cari buku">
                    <button type="submit"
                        class="w-[120px] h-[50px] hover:bg-[#E55A00] bg-[#FF6500] text-[#D9D9D9] font-poppins font-bold rounded-[8px] text-[20px]">
                        Cari
                    </button>
                </form>
            </section>

            <!-- Gambar Ilustrasi -->
            <aside class="pe-[70px]" data-aos="fade-left">
                <img class="w-[500px] h-[362px] pt-[100px]" src="./img/illustrasi.svg" alt="Ilustrasi pencarian buku">
            </aside>
        </div>
    </main>

    <!-- Katalog -->
    <section id="katalog" class="w-full py-10 bg-[#F4F4F4]" data-aos="fade-up">
        <div class="container mx-auto px-6">
            <!-- Judul Katalog -->
            <h2 class="text-[36px] font-poppins font-bold text-[#0B192C] text-center mb-8" data-aos="zoom-in">
                Buku Terbaru
            </h2>

            <!-- Daftar Buku -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($books as $book)
                    <div class="bg-white dark:bg-gray-700 rounded-3xl overflow-hidden hover:shadow-sm duration-300">
                        <!-- Bagian yang membuka modal saat diklik -->
                        <div onclick="openModal({{ $book->id }})" class="cursor-pointer">
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover {{ $book->judul }}"
                                class="w-full h-72 object-cover rounded-t-3xl">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white truncate">
                                    {{ $book->judul }}</h3>
                                <p class="text-slate-600 dark:text-gray-300 text-sm mt-2 flex items-center">
                                    Penulis: {{ $book->penulis }}
                                </p>
                                <p class="text-slate-600 dark:text-gray-300 text-sm flex items-center">
                                    Penerbit: {{ $book->penerbit }}
                                </p>
                                <p class="text-slate-600 dark:text-gray-300 text-sm flex items-center">
                                    Kategori:
                                    {{ $book->kategori->nama_kategori }}
                                </p>
                            </div>
                        </div>
                        <!-- Tombol Pinjam Buku -->
                        <div class="p-5">
                            <a href="{{ route('peminjaman', ['id' => $book->id]) }}">
                                <button
                                    class="w-full bg-[#FF6500] text-white py-3 rounded-xl font-bold hover:bg-[#E55A00] transition duration-300 transform hover:scale-105 flex items-center justify-center"
                                    onclick="event.stopPropagation()">
                                    Pinjam Buku
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="layanan-kami" class="w-full py-10 bg-[#F4F4F4]" data-aos="fade-up">
        <div class="container mx-auto px-6">
            <h2 class="text-[36px] font-poppins font-bold text-[#0B192C] text-center mb-8" data-aos="zoom-in">
                Layanan Kami
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-700 rounded-3xl p-6 text-center hover:shadow-sm duration-300">
                    <i class="fas fa-book-open text-[#FF6500] text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Peminjaman Buku</h3>
                    <p class="text-slate-600 dark:text-gray-300">Pinjam buku favorit Anda dengan mudah dan cepat.</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-3xl p-6 text-center hover:shadow-sm duration-300">
                    <i class="fas fa-search text-[#FF6500] text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Pencarian Cepat</h3>
                    <p class="text-slate-600 dark:text-gray-300">Temukan buku berdasarkan judul, penulis, atau kategori.
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-3xl p-6 text-center hover:shadow-sm duration-300">
                    <i class="fas fa-clock text-[#FF6500] text-4xl mb-4"></i>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Pengembalian Mudah</h3>
                    <p class="text-slate-600 dark:text-gray-300">Kembalikan buku dengan proses yang sederhana dan cepat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="w-full py-10 bg-[#F4F4F4]" data-aos="fade-up">
        <div class="container mx-auto px-6">
            <h2 class="text-[36px] font-poppins font-bold text-[#0B192C] text-center mb-8" data-aos="zoom-in">
                FAQ
            </h2>
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white dark:bg-gray-700 rounded-3xl p-6 hover:shadow-sm duration-300">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Bagaimana cara meminjam buku?</h3>
                    <p class="text-slate-600 dark:text-gray-300">Anda dapat meminjam buku dengan mencari buku yang Anda
                        inginkan, lalu klik tombol "Pinjam Buku".</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-3xl p-6 hover:shadow-sm duration-300">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Berapa lama waktu peminjaman?</h3>
                    <p class="text-slate-600 dark:text-gray-300">Waktu peminjaman biasanya 14 hari, namun dapat
                        diperpanjang jika diperlukan.</p>
                </div>
                <div class="bg-white dark:bg-gray-700 rounded-3xl p-6 hover:shadow-sm duration-300">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Apakah ada biaya peminjaman?</h3>
                    <p class="text-slate-600 dark:text-gray-300">Tidak, PinBook tidak mengenakan biaya peminjaman.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <x-footer />

    <!-- Inisialisasi AOS -->
    <script>
        AOS.init({
            duration: 1000, // Durasi animasi dalam milidetik
            once: true, // Animasi hanya berjalan sekali saat pertama kali muncul
        });
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>

</html>
