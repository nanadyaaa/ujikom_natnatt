<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kebijakan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg overflow-hidden">
                <div class="flex justify-between items-center px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 tracking-wide">Data Kebijakan
                    </h3>
                    <button onclick="return addData()"
                        class="bg-[#5A827E] hover:bg-[#A4C494] text-gray-200 font-medium px-5 py-2 shadow-md transition duration-300">
                        Tambah Kebijakan
                    </button>
                </div>

                {{-- Jika ingin search, bisa tambah form ini seperti di anggota --}}
                {{-- <form method="GET" action="{{ route('kebijakan.index') }}" class="px-6 py-4 flex justify-end">
                    <input type="text" name="search" placeholder="Cari kebijakan..."
                        class="border border-gray-300 rounded-l-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" />
                    <button type="submit"
                        class="bg-[#B9D4AA] hover:bg-[#A4C494] text-gray-800 font-medium px-4 py-2 rounded-r-lg transition duration-300">
                        Cari
                    </button>
                </form> --}}

                <div class="overflow-x-auto mx-auto" style="max-width: 95%; margin-top: 1rem;">
                    <table
                        class="min-w-full table-auto border border-gray-300 dark:border-gray-600 text-sm text-gray-800 dark:text-gray-200 overflow-hidden">
                        <thead style="background-color: #5A827E;" class="text-white">
                            <tr>
                                <th
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left ">
                                    No</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Maximal
                                    Waktu Pinjam</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Maximal
                                    Jumlah Koleksi</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Denda</th>
                                <th
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($data->currentPage() - 1) * $data->perPage() + 1; @endphp
                            @forelse ($data as $d)
                                <tr class="hover:bg-[#B9D4AA] transition duration-150">
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $no++ }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $d->max_wkt_pjm }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                        {{ $d->max_jml_koleksi }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $d->denda }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center space-x-2">
                                        <button
                                            onclick="return updateData('{{ $d->id }}','{{ $d->max_wkt_pjm }}','{{ $d->max_jml_koleksi }}','{{ $d->denda }}','{{ route('kebijakan.update', $d->id) }}')"
                                            class="text-yellow-500 hover:text-yellow-600 transition">
                                            ✏️
                                        </button>
                                        <button
                                            onclick="return deleteData('{{ $d->id }}','{{ route('kebijakan.destroy', $d->id) }}')"
                                            class="text-red-600 hover:text-red-700 transition">
                                            ❌
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
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

    {{-- Modal Tambah --}}
    <div id="modal-addData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 w-full max-w-md shadow-xl">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Tambah Kebijakan</h2>
            <form id="addForm" action="{{ route('kebijakan.store') }}" method="post">
                @csrf
                <label>Maximal Waktu Pinjam</label>
                <input type="number" name="max_wkt_pjm" class="input w-full mb-2" required />
                <label>Maximal Jumlah Koleksi</label>
                <input type="number" name="max_jml_koleksi" class="input w-full mb-2" required />
                <label>Denda</label>
                <input type="number" name="denda" class="input w-full mb-2" required />
                <div class="mt-4 flex justify-end gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="closeModalAdd()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Update --}}
    <div id="modal-updateData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 w-full max-w-md shadow-xl">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Update Kebijakan</h2>
            <form id="updateForm" method="post">
                @csrf
                @method('PATCH')
                <label>Maximal Waktu Pinjam</label>
                <input type="number" name="max_wkt_pjm" id="update_max_wkt_pjm" class="input w-full mb-2" required />
                <label>Maximal Jumlah Koleksi</label>
                <input type="number" name="max_jml_koleksi" id="update_max_jml_koleksi" class="input w-full mb-2"
                    required />
                <label>Denda</label>
                <input type="number" name="denda" id="update_denda" class="input w-full mb-2" required />
                <div class="mt-4 flex justify-end gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="closeModalUpdate(event)"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="modal-deleteData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 w-full max-w-md shadow-xl">
            <h2 class="text-lg font-bold text-red-600 mb-4">Konfirmasi Hapus</h2>
            <form id="deleteForm" method="post">
                @csrf
                @method('DELETE')
                <p id="delete-message" class="mb-4 text-gray-800 dark:text-gray-100"></p>
                <div class="flex justify-end gap-2">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Hapus</button>
                    <button type="button" onclick="closeModalDelete()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        function addData() {
            document.getElementById("addForm").reset();
            document.getElementById("modal-addData").classList.remove("hidden");
        }

        function closeModalAdd() {
            document.getElementById("modal-addData").classList.add("hidden");
        }

        function updateData(id, maxWkt, maxJml, denda, routeUrl) {
            document.getElementById("update_max_wkt_pjm").value = maxWkt;
            document.getElementById("update_max_jml_koleksi").value = maxJml;
            document.getElementById("update_denda").value = denda;
            const updateForm = document.getElementById("updateForm");
            updateForm.action = routeUrl;
            document.getElementById("modal-updateData").classList.remove("hidden");
        }

        function closeModalUpdate(event) {
            event.preventDefault();
            document.getElementById("modal-updateData").classList.add("hidden");
        }

        function deleteData(id, routeUrl) {
            const deleteForm = document.getElementById("deleteForm");
            deleteForm.action = routeUrl;
            document.getElementById("delete-message").innerText = "Yakin ingin menghapus data kebijakan nomor " + id + "?";
            document.getElementById("modal-deleteData").classList.remove("hidden");
        }

        function closeModalDelete() {
            document.getElementById("modal-deleteData").classList.add("hidden");
        }
    </script>
</x-app-layout>