<!-- Create Book Modal -->

<div id="createBookModal" class="modal fixed inset-0 flex items-center justify-center" style="display: none;">
    <div class="bg-gray-800 text-[#FF6500] rounded-lg p-6 shadow-lg w-1/2">
        <h2 class="text-2xl font-semibold mb-4 font-poppins">Tambah Buku</h2>
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium">Judul</label>
                <input type="text" name="judul" id="judul" placeholder="Masukkan judul buku"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="penerbit" class="block text-sm font-medium">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" placeholder="Masukkan nama penerbit"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="penulis" class="block text-sm font-medium">Penulis</label>
                <input type="text" name="penulis" id="penulis" placeholder="Masukkan nama penulis"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="diterbitkan" class="block text-sm font-medium">Di Terbitkan</label>
                <input type="date" name="diterbitkan" id="diterbitkan" placeholder="Pilih tanggal terbit"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="cover" class="block text-sm font-medium text-gray-200 mb-2">Cover Buku :</label>
                <input type="file" id="cover" name="cover" required
                    class="w-full bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg p-3 focus:outline-none">
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-lg mr-2"
                    onclick="toggleModal('createBookModal')">Batal</button>
                <button type="submit"
                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.style.display === 'none' || modal.style.display === '') {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('show'), 10); // Tambahkan kelas setelah modal ditampilkan
        } else {
            modal.classList.remove('show');
            setTimeout(() => modal.style.display = 'none', 300); // Tunggu animasi selesai sebelum menyembunyikan
        }
    }
</script>
