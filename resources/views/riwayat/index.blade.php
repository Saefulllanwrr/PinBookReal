<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - PinBook</title>

    @if (app()->environment('local'))
        @vite(['resources/css/pagination.css', 'resources/css/app.css'])
    @endif

    <!-- Menambahkan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-slate-50 font-poppins">

    <!-- Navbar -->
    <x-navbar class="fixed top-0 left-0 w-full bg-white shadow-md z-50"></x-navbar>

    <!-- Spasi untuk Navbar -->
    <div class="h-20"></div>
    @auth
        <div class="container mx-auto mt-8 px-4">
            <div class="bg-white shadow-lg rounded-xl p-6">

                <!-- Filter Section -->
                <div class="mb-6 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <select id="statusFilter"
                        class="px-4 py-2 border border-slate-600 text-slate-600 focus:outline-none rounded-lg w-full md:w-1/2 lg:w-1/6">
                        <option value="">Semua Status</option>
                        <option value="dipinjam">Dipinjam</option>
                        <option value="dikembalikan">Dikembalikan</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                    <button id="resetFilter"
                        class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition duration-200 w-full md:w-auto">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-sm">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600 text-left text-sm font-semibold">
                                <th class="py-3 px-6">Judul Buku</th>
                                <th class="py-3 px-6">Tanggal Pinjam</th>
                                <th class="py-3 px-6">Tanggal Kembali</th>
                                <th class="py-3 px-6 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($riwayat as $item)
                                <tr class="border-b border-slate-200 hover:bg-slate-50 transition duration-200"
                                    data-status="{{ strtolower($item->status) }}">
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
                                    <td colspan="4" class="py-4 px-6 text-center text-slate-500">
                                        Tidak ada riwayat peminjaman
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
            document.getElementById('resetFilter').addEventListener('click', resetFilters);

            function filterTable() {
                const statusFilter = document.getElementById('statusFilter').value.trim().toLowerCase();
                const rows = document.querySelectorAll('#tableBody tr');

                rows.forEach(row => {
                    const status = row.dataset.status;
                    const statusMatch = statusFilter === '' || status === statusFilter;

                    row.style.display = statusMatch ? '' : 'none';
                });
            }

            function resetFilters() {
                document.getElementById('statusFilter').value = '';
                filterTable();
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
