<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - PinBook</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 font-poppins">

    <!-- Navbar -->
    <x-navbar class="fixed top-0 left-0 w-full bg-white shadow-md z-50"></x-navbar>

    <!-- Spasi untuk Navbar -->
    <div class="h-20"></div>

    <div class="container mx-auto px-4">
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">📖 Riwayat Peminjaman</h2>

            <!-- Tabel Responsive -->
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
                    <tbody>
                        @forelse ($riwayat as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">
                                <td class="py-4 px-6">{{ $item->book->judul }}</td>
                                <td class="py-4 px-6">{{ $item->tanggal_pinjam }}</td>
                                <td class="py-4 px-6">{{ $item->tanggal_kembali ?? '-' }}</td>
                                <td class="py-4 px-6 text-center">
                                    @if ($item->tanggal_kembali)
                                        <span
                                            class="px-3 py-1 text-sm font-semibold text-green-600 bg-green-100 rounded-full">Dikembalikan</span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-sm font-semibold text-red-600 bg-red-100 rounded-full">Dipinjam</span>
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

</body>

</html>
