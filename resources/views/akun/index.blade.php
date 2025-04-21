<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <x-navbar></x-navbar>
    <div class="min-h-screen flex justify-center items-center p-4 pt-16">
        <div class="bg-white shadow-2xl rounded-lg p-8 w-full max-w-4xl">
            <!-- Tab Navigasi -->
            <div class="flex justify-center mb-8 border-b border-gray-200">
                <button onclick="switchTab('profile')" id="profileTab"
                    class="px-6 py-2 text-lg font-semibold text-gray-800 border-b-2 border-blue-500 focus:outline-none transition duration-300">
                    Profil
                </button>
                <button onclick="switchTab('settings')" id="settingsTab"
                    class="px-6 py-2 text-lg font-semibold text-gray-800 border-b-2 border-transparent hover:border-blue-500 focus:outline-none transition duration-300">
                    Pengaturan
                </button>
            </div>

            <!-- Konten Tab Profil -->
            <div id="profileContent" class="tab-content">
                <div class="flex flex-col items-center">
                    <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}"
                        class="w-24 h-24 rounded-full shadow-lg" alt="Avatar">
                    <h2 class="text-3xl font-bold text-gray-800 mt-4">{{ $users->username }}</h2>
                    <p class="text-gray-600 mt-2">{{ $users->email }}</p>
                    <button onclick="openModal()"
                        class="mt-6 bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300 transform hover:scale-110">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </button>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i>
                                <span class="text-gray-600">Nama Lengkap:</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $users->name }}</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                <span class="text-gray-600">Email:</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $users->email }}</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-blue-500 mr-2"></i>
                                <span class="text-gray-600">Nomor Telepon:</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ $users->no_telepon ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten Tab Pengaturan -->
            <div id="settingsContent" class="tab-content hidden">
                <div class="space-y-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Akun</h3>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ $users->name }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="username" class="block text-gray-700">Username</label>
                                <input type="text" name="username" id="username" value="{{ $users->username }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ $users->email }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="no_telepon" class="block text-gray-700">Nomor Telepon</label>
                                <input type="text" name="no_telepon" id="no_telepon"
                                    value="{{ $users->no_telepon ?? '' }}"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Ubah Password</h3>
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="current_password" class="block text-gray-700">Password Saat Ini</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="block text-gray-700">Password Baru</label>
                                <input type="password" name="new_password" id="new_password"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="block text-gray-700">Konfirmasi Password
                                    Baru</label>
                                <input type="password" name="new_password_confirmation"
                                    id="new_password_confirmation"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Ubah
                                    Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tombol Logout -->
            <div class="mt-8 text-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="bg-red-500 text-white px-6 py-2 rounded-full hover:bg-red-600 transition duration-300 transform hover:scale-110">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div id="editProfileModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white rounded-lg p-8 w-full max-w-md relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Profil</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="modal_name" class="block text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="modal_name" value="{{ $users->name }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="modal_username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" id="modal_username" value="{{ $users->username }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="modal_email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="modal_email" value="{{ $users->email }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="modal_no_telepon" class="block text-gray-700">Nomor Telepon</label>
                    <input type="text" name="no_telepon" id="modal_no_telepon"
                        value="{{ $users->no_telepon ?? '' }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </button>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk beralih tab
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(tabName + 'Content').classList.remove('hidden');

            document.querySelectorAll('[id$="Tab"]').forEach(tab => {
                tab.classList.remove('border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-800');
            });

            document.getElementById(tabName + 'Tab').classList.add('border-blue-500', 'text-blue-600');
            document.getElementById(tabName + 'Tab').classList.remove('border-transparent', 'text-gray-800');
        }

        // Fungsi untuk membuka modal edit profil
        function openModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Fungsi untuk menutup modal edit profil
        function closeModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Tutup modal ketika klik di luar modal
        window.onclick = function(event) {
            const modal = document.getElementById('editProfileModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
