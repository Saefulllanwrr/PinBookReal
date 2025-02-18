<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <title>PinBook - Aplikasi Peminjaman Buku</title>
    @vite('resources/css/app.css')
</head>

<body>

    <!-- Header -->
    <x-navbar />

    <!-- Notifikasi -->
    @if (session('success'))
        <div
            class="fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($books as $book)
                    <!-- Buku Item -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}"
                            class="w-full h-[200px] object-cover">
                        <div class="p-4">
                            <h3 class="font-poppins font-semibold text-[20px] text-[#0B192C] mb-2">{{ $book->judul }}
                            </h3>
                            <div class="mt-auto">
                                <a href="{{ route('peminjaman', ['id' => $book->id]) }}">
                                    <button
                                        class="w-full bg-[#FF6500] text-white py-2 rounded-lg font-bold hover:bg-[#E55A00]">
                                        Pinjam
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <!-- Kontak Section -->
    <section id="kontak" class="w-full py-10 bg-white" data-aos="fade-up">
        <div class="container mx-auto px-6">
            <!-- Judul Kontak -->
            <h2 class="text-[36px] font-poppins font-bold text-[#0B192C] text-center mb-8" data-aos="zoom-in">
                Hubungi Kami
            </h2>

            <!-- Form Kontak -->
            <div class="max-w-2xl mx-auto bg-[#F4F4F4] p-8 rounded-lg shadow-md" data-aos="fade-up"
                data-aos-delay="200">
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="name" class="block font-poppins font-medium text-[#0B192C] mb-2">Nama</label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-2 rounded-lg border border-[#D9D9D9] focus:outline-none focus:border-[#FF6500]"
                            placeholder="Masukkan nama Anda">
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block font-poppins font-medium text-[#0B192C] mb-2">Email</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 rounded-lg border border-[#D9D9D9] focus:outline-none focus:border-[#FF6500]"
                            placeholder="Masukkan email Anda">
                    </div>
                    <div class="mb-6">
                        <label for="message" class="block font-poppins font-medium text-[#0B192C] mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-2 rounded-lg border border-[#D9D9D9] focus:outline-none focus:border-[#FF6500]"
                            placeholder="Masukkan pesan Anda"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="w-full bg-[#FF6500] text-white py-2 rounded-lg font-bold hover:bg-[#E55A00]">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informasi Kontak -->
            <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="400">
                <h3 class="font-poppins font-bold text-[24px] text-[#0B192C] mb-4">Atau hubungi kami melalui:</h3>
                <div class="flex justify-center items-center gap-6">
                    <a href="mailto:info@pinbook.com" class="text-[#FF6500] hover:text-[#E55A00]">
                        <i class="fas fa-envelope text-3xl"></i>
                    </a>
                    <a href="https://wa.me/62085720800889" class="text-[#FF6500] hover:text-[#E55A00]">
                        <i class="fab fa-whatsapp text-3xl"></i>
                    </a>
                    <a href="https://www.instagram.com/saefullanwrrr" class="text-[#FF6500] hover:text-[#E55A00]">
                        <i class="fab fa-instagram text-3xl"></i>
                    </a>
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

    <!-- Script untuk menghilangkan notifikasi otomatis -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah perilaku default
                const targetId = this.getAttribute('href').substring(1); // Ambil ID target
                const targetElement = document.getElementById(targetId); // Dapatkan elemen target

                if (targetElement) {
                    // Scroll ke elemen target dengan efek smooth
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.querySelector('.fixed.bg-green-500');
            if (notification) {
                setTimeout(() => {
                    notification.remove();
                }, 5000); // 5000 milidetik = 5 detik
            }
        });
    </script>
</body>

</html>
