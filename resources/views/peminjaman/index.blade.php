<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinBook Peminjaman</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 font-poppins">

    <!-- Navbar -->
    <x-navbar class="fixed top-0 left-0 w-full bg-white shadow-md z-50"></x-navbar>

    <!-- Spasi untuk Navbar -->
    <div class="h-20"></div>

    <div class="container mx-auto mt-4 px-4">
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">📚 Buku yang Sedang Dipinjam</h2>

            <!-- Notifikasi Pesan -->
            @if (session('status'))
                <div
                    class="flex items-center bg-green-500 text-white text-sm font-semibold p-4 rounded-lg shadow-md mb-6">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <!-- Tabel Buku yang Dipinjam -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-left text-sm font-semibold">
                            <th class="py-3 px-6">Judul Buku</th>
                            <th class="py-3 px-6">Tanggal Pinjam</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjaman as $pinjam)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">
                                <td class="py-4 px-6">{{ $pinjam->book->judul }}</td>
                                <td class="py-4 px-6">{{ $pinjam->tanggal_pinjam }}</td>
                                <td class="py-4 px-6 text-center">
                                    <!-- Tombol Pengembalian Buku -->
                                    <button type="button" onclick="confirmReturn({{ $pinjam->id }})"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-red-600 transition duration-300">
                                        Kembalikan
                                    </button>
                                    <button type="button" onclick="openDonationForm({{ $pinjam->id }})"
                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-blue-600 transition duration-300">
                                        Donate
                                    </button>

                                    <!-- Formulir pengembalian buku -->
                                    <form id="return-form-{{ $pinjam->id }}"
                                        action="{{ route('buku.kembalikan', $pinjam->id) }}" method="POST"
                                        class="hidden">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-center text-gray-500">
                                    ❌ Tidak ada buku yang sedang dipinjam
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        /**
         * Menampilkan konfirmasi sebelum mengembalikan buku
         */
        function confirmReturn(bookId) {
            Swal.fire({
                title: "Konfirmasi Pengembalian",
                text: "Apakah Anda yakin ingin mengembalikan buku ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Kembalikan",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form pengembalian buku
                    let form = document.getElementById("return-form-" + bookId);
                    if (form) {
                        form.submit();
                    } else {
                        Swal.fire("Error", "Formulir tidak ditemukan!", "error");
                    }
                }
            });
        }

        /**
         * Menampilkan form input untuk donasi
         */
        function openDonationForm(bookId) {
            Swal.fire({
                title: "Masukkan Nominal Donasi",
                input: "number",
                inputAttributes: {
                    min: 1000, // Minimal donasi
                    step: 1000 // Kelipatan donasi
                },
                showCancelButton: true,
                confirmButtonText: "Donate",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    const amount = result.value;
                    if (amount >= 1000) {
                        processDonation(amount, bookId);
                    } else {
                        Swal.fire("Kesalahan", "Nominal donasi minimal Rp 1000.", "error");
                    }
                }
            });
        }

        /**
         * Mengirim request AJAX untuk memproses donasi dengan Midtrans
         */
        function processDonation(amount, bookId) {
            $.ajax({
                url: "{{ route('donate.process') }}", // Route ke controller donasi
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    amount: amount,
                    book_id: bookId,
                    name: "{{ auth()->user()->name }}",
                    email: "{{ auth()->user()->email }}",
                },
                success: function(response) {
                    // Menjalankan pembayaran dengan Midtrans
                    snap.pay(response.snap_token, {
                        onSuccess: function(result) {
                            handlePaymentResponse(result, "success");
                        },
                        onPending: function(result) {
                            handlePaymentResponse(result, "pending");
                        },
                        onError: function(result) {
                            handlePaymentResponse(result, "error");
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire("Kesalahan", "Terjadi kesalahan saat memproses donasi.", "error");
                    console.error(xhr.responseText);
                }
            });
        }

        /**
         * Menangani respons pembayaran dari Midtrans
         */
        function handlePaymentResponse(result, status) {
            let message;
            switch (status) {
                case "success":
                    message = "Terima kasih atas donasi Anda!";
                    break;
                case "pending":
                    message = "Pembayaran Anda sedang diproses.";
                    break;
                case "error":
                    message = "Terjadi kesalahan dalam pembayaran.";
                    break;
            }

            Swal.fire({
                title: status === "success" ? "Berhasil!" : "Gagal!",
                text: message,
                icon: status === "success" ? "success" : "error"
            }).then(() => {
                if (status === "success") {
                    location.reload(); // Reload halaman setelah sukses
                }
            });
        }
    </script>

</body>

</html>
