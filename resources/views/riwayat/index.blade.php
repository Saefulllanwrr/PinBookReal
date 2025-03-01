<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - PinBook</title>

    @if (app()->environment('local'))
        @vite(['resources/css/pagination.css', 'resources/css/app.css'])
    @endif
</head>

<body class="bg-gray-50 font-poppins">

    <!-- Navbar -->
    <div class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
        <x-navbar></x-navbar>
    </div>

    <!-- Spasi untuk Navbar -->
    <div class="h-20"></div>

    @auth
        <div class="container mx-auto px-4">
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h2 class="text-3xl font-bold mb-6 text-gray-800">📖 Riwayat Peminjaman</h2>

                <!-- Filter Section -->
                <div class="mb-6 flex space-x-4">
                    <select id="statusFilter" class="px-4 py-2 border rounded-lg">
                        <option value="">Semua Status</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="dikembalikan">Dikembalikan</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                    <input type="text" id="searchInput" class="px-4 py-2 border rounded-lg"
                        placeholder="Cari judul buku...">
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-sm">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-left text-sm font-semibold">
                                <th class="py-3 px-6">Judul Buku</th>
                                <th class="py-3 px-6">Tanggal Pinjam</th>
                                <th class="py-3 px-6">Tanggal Kembali</th>
                                <th class="py-3 px-6 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($riwayat as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200"
                                    data-status="{{ strtolower($item->status) }}"
                                    data-judul="{{ strtolower($item->book->judul) }}">
                                    <td class="py-4 px-6">{{ $item->book->judul }}</td>
                                    <td class="py-4 px-6">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                                    <td class="py-4 px-6">
                                        {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($item->status === 'dipinjam')
                                            <span class="text-yellow-500 font-semibold">{{ ucfirst($item->status) }}</span>
                                        @elseif($item->status === 'dikembalikan')
                                            <span class="text-green-500 font-semibold">{{ ucfirst($item->status) }}</span>
                                        @elseif($item->status === 'terlambat')
                                            <span class="text-red-500 font-semibold">{{ ucfirst($item->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                                        ❌ Tidak ada riwayat peminjaman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="my-8 flex justify-center">
            {{ $riwayat->links('vendor.pagination.custom') }}
        </div>

        <script>
            document.getElementById('statusFilter').addEventListener('change', filterTable);
            document.getElementById('searchInput').addEventListener('input', filterTable);

            function filterTable() {
                const statusFilter = document.getElementById('statusFilter').value.trim().toLowerCase();
                const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
                const rows = document.querySelectorAll('#tableBody tr');

                rows.forEach(row => {
                    const status = row.dataset.status;
                    const judul = row.dataset.judul;

                    const statusMatch = statusFilter === '' || status === statusFilter;
                    const searchMatch = judul.includes(searchInput);

                    row.style.display = statusMatch && searchMatch ? '' : 'none';
                });
            }
        </script>
    @else
        <script>
            alert('Anda harus login untuk melihat riwayat peminjaman!');
            window.location.href = "{{ route('login') }}";
        </script>
    @endauth

</body>

</html>
