<!-- Hero Section -->
<main class="w-full h-[462px] bg-[#0B192C] relative">
    <img class="absolute h-full w-full object-cover" src="./img/bg.png" alt="Latar belakang PinBook">
    <div class="relative flex items-center h-full pb-20">
        <!-- Teks Sambutan -->
        <section class="w-[837px] ms-[59px] flex flex-col justify-center data-aos="fade-left" ">
            <h2 class="font-poppins font-bold text-[40px] text-white pt-[70px]">
                Selamat datang  @if (Auth::check())
            {{ Auth::user()->name }}
            @endif di Website <span class="text-[#FF6500]">PinBook</span>
            </h2>
            <p class="font-poppins font-light text-[24px] text-[#D9D9D9] mt-1">
                Aplikasi peminjaman buku yang praktis, cepat, dan menghemat waktu Anda.
                Temukan buku favorit Anda, pinjam dengan mudah, dan nikmati pengalaman membaca tanpa ribet!
            </p>

            <!-- Form Pencarian -->
            <!-- Form Pencarian -->
            <form class="mt-8 flex items-center gap-4" action="{{ route('search') }}" method="GET">
                <input type="text" name="query" placeholder="Cari buku berdasarkan judul, pengarang..."
                    class="w-[500px] h-[50px] px-4 rounded-[8px] text-[#0B192C] border-none font-poppins text-[16px] focus:outline-none"
                    aria-label="Cari buku">
                <button type="submit"
                    class="w-[120px] h-[50px]  hover:bg-[#E55A00] bg-[#FF6500] text-[#D9D9D9] font-poppins font-bold rounded-[8px] text-[20px]">
                    Cari
                </button>
            </form>

        </section>

        <!-- Gambar Ilustrasi -->
        <aside class="pe-[70px]">
            <img class="w-[500px] h-[362px] pt-[100px]" src="./img/illustrasi.svg" alt="Ilustrasi pencarian buku">
        </aside>
    </div>
</main>
