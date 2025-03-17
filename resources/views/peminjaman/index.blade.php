<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinBook Peminjaman</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @notifyCss
    @notifyJs
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 font-poppins">

    <x-notify::notify />
    <!-- Navbar -->
    <x-navbar class="fixed top-0 left-0 w-full bg-white shadow-md z-50"></x-navbar>

    <!-- Spasi untuk Navbar -->
    <div class="h-20"></div>

    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white shadow-lg rounded-xl p-8">




            <!-- Tabel Buku yang Dipinjam -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-sm">
                    <thead>
                        <tr class="bg-slate-100 text-slate-600 text-left text-sm font-semibold">
                            <th class="py-4 px-6">Judul Buku</th>
                            <th class="py-4 px-6">Tanggal Pinjam</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $pinjam)
                            <tr class="border-b border-slate-200 hover:bg-slate-50 transition duration-200">
                                <td class="py-5 px-6">{{ $pinjam->book->judul }}</td>
                                <td class="py-5 px-6">{{ $pinjam->tanggal_pinjam }}</td>
                                <td class="py-5 px-6">
                                    <span
                                        class="px-3 py-1 rounded-full text-white text-sm font-semibold 
                    {{ $pinjam->status == 'menunggu' ? 'bg-yellow-500' : ($pinjam->status == 'dipinjam' ? 'bg-blue-500' : 'bg-green-500') }}">
                                        {{ ucfirst($pinjam->status) }}
                                    </span>
                                </td>


                                <td class="py-5 px-6 text-center space-x-4">
                                    @if ($pinjam->status == 'menunggu')
                                        <form action="{{ route('peminjaman.cancel', $pinjam->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-5 py-2.5 rounded-lg font-semibold shadow hover:bg-red-600 transition duration-300">
                                                Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-sm">Tidak dapat dibatalkan</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 px-6 text-center text-slate-500">
                                    Tidak ada buku yang sedang dipinjam
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
