<!-- Create Category Modal -->
<div id="createKategoriModal" class="modal fixed inset-0 flex items-center justify-center" style="display: none;">
    <div class="bg-gray-800 text-[#FF6500] rounded-lg p-6 shadow-lg w-1/2">
        <h2 class="text-2xl font-semibold mb-4 font-poppins">Tambah Kategori</h2>
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_kategori" class="block text-sm font-medium">Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" placeholder="Masukkan kategori buku"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>

            <div class="flex justify-end">
                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-lg mr-2"
                    onclick="toggleModal('createKategoriModal')">Batal</button>
                <button type="submit"
                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>


<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        // Cek apakah modal sudah ada di dalam DOM
        if (!modal) return;

        if (modal.style.display === 'none' || modal.style.display === '') {
            modal.style.display = 'flex'; // Tampilkan modal
        } else {
            modal.style.display = 'none'; // Sembunyikan modal
        }
    }
</script>
