<!-- Edit Book Modal -->
<div id="editBookModal" class="modal fixed inset-0 flex items-center justify-center" style="display: none;">
    <div class="bg-gray-800 text-[#FF6500] rounded-lg p-6 shadow-lg w-1/2">
        <h2 class="text-2xl font-semibold mb-4 font-poppins">Edit Buku</h2>
        <form id="editBookForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_judul" class="block text-sm font-medium">Judul</label>
                <input type="text" name="judul" id="edit_judul"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="edit_penerbit" class="block text-sm font-medium">Penerbit</label>
                <input type="text" name="penerbit" id="edit_penerbit"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="edit_penulis" class="block text-sm font-medium">Penulis</label>
                <input type="text" name="penulis" id="edit_penulis"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="edit_diterbitkan" class="block text-sm font-medium">Di Terbitkan</label>
                <input type="date" name="diterbitkan" id="edit_diterbitkan"
                    class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none">
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-lg mr-2"
                    onclick="toggleModal('editBookModal')">Batal</button>
                <button type="submit"
                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(book) {
        document.getElementById('edit_judul').value = book.judul;
        document.getElementById('edit_penerbit').value = book.penerbit;
        document.getElementById('edit_penulis').value = book.penulis;
        document.getElementById('edit_diterbitkan').value = book.diterbitkan;
        document.getElementById('editBookForm').action = `/books/${book.id}`;
        toggleModal('editBookModal');
    }

    document.querySelector('a[href="{{ route('books.create') }}"]').addEventListener('click', function(event) {
        event.preventDefault();
        toggleModal('createBookModal');
    });
</script>
