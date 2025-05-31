<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Koleksi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg overflow-hidden">
                <div class="flex justify-between items-center px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 tracking-wide">Data Koleksi</h3>
                    <button onclick="return addData()"
                        class="bg-[#5A827E] hover:bg-[#A4C494] text-gray-200 font-medium px-5 py-2 shadow-md transition duration-300 rounded-md">
                        Tambah Koleksi
                    </button>
                </div>
                <form method="GET" action="{{ route('koleksi.index') }}" class="px-6 py-4 flex justify-end">
                    <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul atau pengarang..."
                        class="border border-gray-300 rounded-l-md px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" />
                    <button type="submit"
                        class="bg-[#B9D4AA] hover:bg-[#A4C494] text-gray-800 font-medium px-4 py-2 rounded-r-md transition duration-300">
                        Cari
                    </button>
                </form>

                <div class="overflow-x-auto mx-auto" style="max-width: 95%; margin-top: 1rem;">
                    <table
                        class="min-w-full table-auto border border-gray-300 dark:border-gray-600 text-sm text-gray-800 dark:text-gray-200 overflow-hidden">
                        <thead style="background-color: #5A827E;" class="text-white">
                            <tr>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 ">No</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Kode</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Judul</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Pengarang</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Penerbit</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center ">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($data->currentPage() - 1) * $data->perPage() + 1; @endphp
                            @forelse ($data as $item)
                                <tr class="hover:bg-[#B9D4AA] transition duration-150">
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $no++ }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                        {{ $item->kd_koleksi }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $item->judul }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $item->pengarang }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $item->penerbit }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center space-x-2">
                                        <button
                                            onclick="return updateData('{{ $item->id }}','{{ $item->judul }}','{{ $item->pengarang }}','{{ $item->penerbit }}','{{ $item->jumlah }}','{{ route('koleksi.update', $item->id) }}')"
                                            class="text-yellow-500 hover:text-yellow-600 transition">
                                            ✏️
                                        </button>
                                        <button
                                            onclick="return deleteData('{{ $item->id }}','{{ $item->judul }}','{{ route('koleksi.destroy', $item->id) }}')"
                                            class="text-red-600 hover:text-red-700 transition">
                                            ❌
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="text-center text-gray-500 italic border border-gray-300 dark:border-gray-600 py-3">
                                        Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="modal-addData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 w-full max-w-md shadow-xl rounded-xl border border-[#5A827E]">
            <h2 class="text-xl font-semibold text-[#5A827E] dark:text-green-400 mb-5">Tambah Koleksi</h2>
            <form id="addForm" action="{{ route('koleksi.store') }}" method="post">
                @csrf
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Kode Koleksi</label>
                <input type="text" name="kd_koleksi"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    value="{{ $codeData }}" readonly />
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Judul</label>
                <input type="text" name="judul"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pengarang</label>
                <input type="text" name="pengarang"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Penerbit</label>
                <input type="text" name="penerbit"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Jumlah</label>
                <input type="number" name="jumlah"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <div class="mt-4 flex justify-end gap-3">
                    <button type="submit"
                        class="bg-[#5A827E] hover:bg-[#4b6f6b] text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">Simpan</button>
                    <button type="button" onclick="closeModalAdd()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">Tutup</button>
                </div>
            </form>
        </div>
    </div>


    <div id="modal-updateData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 w-full max-w-md shadow-xl rounded-xl border border-[#5A827E]">
            <h2 class="text-xl font-semibold text-[#5A827E] dark:text-green-400 mb-5">Update Koleksi</h2>
            <form id="updateForm" method="post">
                @csrf
                @method('PATCH')
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Judul</label>
                <input type="text" name="judul" id="update_judul"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pengarang</label>
                <input type="text" name="pengarang" id="update_pengarang"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Penerbit</label>
                <input type="text" name="penerbit" id="update_penerbit"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Jumlah</label>
                <input type="number" name="jumlah" id="update_jumlah"
                    class="input w-full mb-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md p-2"
                    required />
                <div class="mt-4 flex justify-end gap-3">
                    <button type="submit"
                        class="bg-[#5A827E] hover:bg-[#4b6f6b] text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">Simpan</button>
                    <button type="button" onclick="closeModalUpdate(event)"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">Tutup</button>
                </div>
            </form>
        </div>
    </div>


    <div id="modal-deleteData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 w-full max-w-md shadow-xl rounded-xl border border-[#5A827E]">
            <h2 class="text-xl font-semibold text-red-600 mb-5">Konfirmasi Hapus</h2>
            <form id="deleteForm" method="post">
                @csrf
                @method('DELETE')
                <p id="delete-message" class="mb-4 text-gray-800 dark:text-gray-100"></p>
                <div class="flex justify-end gap-3">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">Hapus</button>
                    <button type="button" onclick="closeModalDelete()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">Batal</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function addData() {
            // Mengosongkan form saat modal tambah dibuka
            document.getElementById("addForm").reset();
            document.getElementById("modal-addData").classList.remove("hidden");
        }

        function closeModalAdd() {
            document.getElementById("modal-addData").classList.add("hidden");
        }

        function updateData(id, judul, pengarang, penerbit, jumlah, routeUrl) {
            // Mengisi form update dengan data yang ada
            document.getElementById("update_judul").value = judul;
            document.getElementById("update_pengarang").value = pengarang;
            document.getElementById("update_penerbit").value = penerbit;
            document.getElementById("update_jumlah").value = jumlah;

            const updateForm = document.getElementById("updateForm");
            updateForm.action = routeUrl; // Menetapkan action URL untuk form update
            document.getElementById("modal-updateData").classList.remove("hidden");
        }

        function closeModalUpdate(event) {
            event.preventDefault();
            document.getElementById("modal-updateData").classList.add("hidden");
        }

        function deleteData(id, judul, routeUrl) {
            const deleteForm = document.getElementById("deleteForm");
            deleteForm.action = routeUrl; // Menetapkan action URL untuk form delete
            const deleteMessage = document.getElementById("delete-message");
            // Pesan konfirmasi yang lebih informatif
            deleteMessage.innerText = `Apakah Anda yakin ingin menghapus koleksi "${judul}"? Data yang dihapus tidak dapat dikembalikan.`;
            document.getElementById("modal-deleteData").classList.remove("hidden");
        }

        function closeModalDelete() {
            document.getElementById("modal-deleteData").classList.add("hidden");
        }

        // Script untuk mengarahkan ulang halaman jika input search kosong
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', function () {
            if (this.value.trim() === '') {
                window.location.href = "{{ route('koleksi.index') }}";
            }
        });
    </script>
</x-app-layout>