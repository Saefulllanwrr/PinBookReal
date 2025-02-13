<!-- Edit Book Modal -->
<div id="editBookModal" class="modal fixed inset-0 flex items-center justify-center" style="display: none;">
    <div class="bg-gray-800 text-[#FF6500] rounded-lg p-6 shadow-lg w-1/2">
        <h2 class="text-2xl font-semibold mb-4 font-poppins">Edit Kategori</h2>
        <form id="editBookForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_kategori" class="block text-sm font-medium">Kategori</label>
                <input type="text" name="nama_kategori" id="edit_kategori" placeholder="Masukkan kategori buku"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="edit_deskripsi" class="block text-sm font-medium">Deskripsi</label>
                <input type="text" name="deskripsi" id="edit_deskripsi" placeholder="Masukkan deskripsi"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>

            <div class="flex justify-end">
                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-lg mr-2"
                    onclick="toggleModal('editBookModal')">Batal</button>
                <button type="submit"
                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">Simpan</button>
            </div>

            <script>
                function toggleModal(modalId) {
                    const modal = document.getElementById(modalId);
                    modal.style.display = (modal.style.display === "flex") ? "none" : "flex";
                }

                function
                openEditModal(kategori) {
                    document.getElementById('edit_kategori').value = kategori.nama_kategori;
                    document.getElementById('edit_deskripsi').value = kategori.deskripsi;
                    document.getElementById('editBookForm').action = `/kategori/${kategori.id}`;
                    toggleModal('editBookModal');
                }
            </script>
