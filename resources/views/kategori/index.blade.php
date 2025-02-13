<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinBook - Kelola Kategori</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-[#0B192C] text-[#D9D9D9] font-poppins">
    <!-- Header -->
    <header class="bg-[#0B192C] py-4 px-6 flex justify-between items-center shadow-md">
        <h1 class="text-xl font-bold">
            Pin<span class="text-[#FF6500]">Book</span> Dashboard
        </h1>
        <button class="flex items-center text-orange-500 hover:text-white transition">
            <i class="fas fa-user-circle mr-2"></i> Admin
        </button>
    </header>

    <div class="flex h-screen relative">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-16 bg-[#FF6500] flex flex-col py-5 ms-[24px] transition-all items-center duration-300 rounded-lg m-4 shadow-lg overflow-hidden h-screen">
            <nav>
                <ul id="navLinks" class="space-y-5">
                    <li
                        class="flex items-center px-4 py-2 rounded-lg text-[#0B192C] hover:bg-gray-700 hover:bg-opacity-40 transition-all">
                        <i class="fas fa-home"></i>
                        <a href="{{ Route('dashboard') }}">
                            <span class="ml-3 hidden font-poppins font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li
                        class="flex items-center px-4 py-2 rounded-lg text-[#0B192C] hover:bg-gray-700 hover:bg-opacity-40 transition-all">
                        <i class="fas fa-users"></i>
                        <a href="{{ Route('manageUser') }}">
                            <span class="ml-3 hidden font-poppins font-medium">Kelola Pengguna</span>
                        </a>
                    </li>
                    <li
                        class="flex items-center px-4 py-2 rounded-lg text-[#0B192C] hover:bg-gray-700 hover:bg-opacity-40 transition-all">
                        <i class="fas fa-book"></i>
                        <a href="{{ route('books.index') }}">

                            <span class="ml-4 hidden font-poppins font-medium">Buku</span>
                        </a>
                    </li>
                    <li
                        class="flex items-center px-4 py-2 rounded-lg text-[#0B192C] hover:bg-gray-700 hover:bg-opacity-40 transition-all">
                        <i class="fa-solid fa-list"></i>
                        <a href="{{ route('kategori.index') }}">

                            <span class="ml-4 hidden font-poppins font-medium">Kategori</span>
                        </a>
                    </li>
                    <li
                        class="flex items-center px-4 py-2 rounded-lg text-[#0B192C] hover:bg-gray-700 hover:bg-opacity-40 transition-all">
                        <i class="fas fa-book-reader"></i>
                        <a href="">
                            <span class="ml-4 hidden font-poppins font-medium">Peminjaman</span>
                        </a>
                    </li>
                    <li
                        class="flex items-center px-4 py-2 rounded-lg text-[#0B192C] hover:bg-gray-700 hover:bg-opacity-40 transition-all">
                        <i class="fas fa-cogs"></i>
                        <a href="">
                            <span class="ml-3 hidden font-poppins font-medium">Setting</span>
                        </a>
                    </li>
                    <li
                        class="flex items-center px-4 py-2 rounded-lg text-red-600 hover:bg-red-700 hover:text-white transition-all">
                        <i class="fas fa-sign-out-alt"></i>
                        <a href="">
                            <span class="ml-3 hidden font-poppins font-medium">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col my-5 relative">
            <!-- Content Section -->
            <section class="flex-shrink bg-gray-800 text-[#FF6500] rounded-lg mx-6 p-6 shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 font-poppins">Kelola Kategori</h2>

                <div class="flex justify-between items-center mb-4">
                    <a href="javascript:void(0)" onclick="toggleModal('createKategoriModal')">
                        <button
                            class="flex items-center px-4 py-2 bg-orange-500 font-semibold rounded-lg shadow hover:bg-orange-600 text-[#0B192C] transition">
                            <i class="fas fa-plus mr-2 text-[#0B192C]"></i> Tambah Kategori
                        </button>
                    </a>
                </div>

                <table class="table-auto border-collapse w-full text-left text-sm text-white">
                    <thead class="bg-gray-700 text-[#FF6500]">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Kategori</th>
                            <th class="px-4 py-2">Deskripsi</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $kategori)
                            <tr class="hover:bg-gray-700 transition-colors">
                                <td class="border-b border-gray-600 px-4 py-2">{{ $kategori->id }}</td>
                                <td class="border-b border-gray-600 px-4 py-2">{{ $kategori->nama_kategori }}</td>
                                <td class="border-b border-gray-600 px-4 py-2">{{ $kategori->deskripsi }}</td>
                                <td class="border-b border-gray-600 px-4 py-2">
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                        style="display: inline;" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 transition">
                                            Hapus
                                        </button>
                                    </form>
                                    <button onclick="openEditModal({{ json_encode($kategori) }})"
                                        class="bg-blue-500 text-white px-2 py-1 rounded-lg hover:bg-blue-600 transition">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (session('success'))
                    <div class="text-green-500 p-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
            </section>
        </main>
    </div>
    <x-modal-create-kategori></x-modal-create-kategori>
    <x-modal-edit-kategori></x-modal-edit-kategori>
    <script>
        const sidebar = document.getElementById('sidebar');
        const navTexts = document.querySelectorAll('#navLinks span');

        sidebar.addEventListener('mouseenter', () => {
            sidebar.classList.remove('w-16');
            sidebar.classList.add('w-60');
            sidebar.classList.remove('items-center')
            navTexts.forEach(text => text.classList.remove('hidden'));
        });

        sidebar.addEventListener('mouseleave', () => {
            sidebar.classList.remove('w-60');
            sidebar.classList.add('w-16');
            sidebar.classList.add('items-center')
            navTexts.forEach(text => text.classList.add('hidden'));
        });

        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus kategori ini?");
        }
    </script>

</body>

</html>
