<header class="fixed z-10 w-full h-[70px] bg-white shadow-md flex items-center px-4 md:px-16">
    <nav class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold text-orange-500">Pin<span class="text-slate-700">Book</span></h1>
        <ul class="hidden md:flex space-x-8 text-slate-700 font-poppins font-medium">
            <li><a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-orange-500' : 'hover:text-orange-500' }}">Beranda</a>
            </li>
            <li><a href="{{ route('katalogBuku') }}"
                    class="{{ request()->routeIs('katalogBuku') ? 'text-orange-500' : 'hover:text-orange-500' }}">Buku</a>
            </li>
            <li><a href="{{ route('peminjaman.index') }}"
                    class="{{ request()->routeIs('peminjaman.index') ? 'text-orange-500' : 'hover:text-orange-500' }}">Peminjaman</a>
            </li>
            <li><a href="{{ route('riwayat.index') }}"
                    class="{{ request()->routeIs('riwayat.index') ? 'text-orange-500' : 'hover:text-orange-500' }}">Riwayat</a>
            </li>
            <li><a href="{{ route('akun.index') }}"
                    class="{{ request()->is('akun.index') ? 'text-orange-500' : 'hover:text-orange-500' }}">Akun</a>
            </li>
        </ul>


        <!-- Login Button (visible when user is not authenticated) -->
        @guest
            <a href="{{ route('login') }}"
                class="bg-orange-500 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-orange-600">Login</a>
        @endguest

        <!-- Profile Button (visible when user is authenticated) -->
        @auth
            <div class="relative">
                <button onclick="toggleDropdown()"
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400">
                    <img src="{{ asset('storage/' . Auth::user()->profile) }}" alt="Profile"
                        class="w-full h-full rounded-full object-cover">
                </button>
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </nav>
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
    }
</script>
