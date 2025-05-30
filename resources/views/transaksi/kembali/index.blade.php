<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('trsKembali') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="px-4 py-4 flex justify-between items-center">
                    <div class="text-lg font-semibold text-green-800 dark:text-green-400">Data Transaksi Kembali</div>
                    <button onclick="addData()"
                        class="bg-[#5A827E] hover:bg-[#4a6d69] text-white px-4 py-2 rounded-md shadow-sm transition duration-300">
                        Tambah trsKembali
                    </button>
                </div>
                <div class="px-6 py-4 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <div class="overflow-hidden rounded-xl shadow">
                        <table id="myDataTable" class="min-w-full table-auto border-collapse text-sm border border-[#5A827E]">
                            <thead class="bg-[#5A827E] text-white">
                                <tr>
                                    <th class="border border-[#5A827E] px-3 py-2">No</th>
                                    <th class="border border-[#5A827E] px-3 py-2">No Transaksi Kembali</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Kode Anggota</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Tanggal Pinjam</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Tanggal Batas Kembali</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Tanggal Kembali</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Kode Koleksi</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Judul</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Denda</th>
                                    <th class="border border-[#5A827E] px-3 py-2">Keterangan</th>
                                    <th class="border border-[#5A827E] px-3 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                                @php $no = 1; @endphp
                                @forelse ($data as $d)
                                    <tr class="hover:bg-[#E6F0EE] dark:hover:bg-[#36534E] transition">
                                        <td class="border border-[#A2B7B5] text-center px-3 py-2">{{ $no++ }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->no_transaksi_kembali }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->kd_anggota }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->tg_pinjam }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->tg_bts_kembali }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->tg_kembali }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->kd_koleksi }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->koleksi->judul }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2 text-right">{{ $d->denda }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2">{{ $d->ket }}</td>
                                        <td class="border border-[#A2B7B5] px-3 py-2 text-center space-x-1">
                                            <button
                                                onclick="return updateData('{{ $d->id }}','{{ $d->kd_anggota }}','{{ $d->tg_pinjam }}','{{ $d->tg_bts_kembali }}','{{ $d->tg_kembali }}','{{ $d->kd_koleksi }}','{{ $d->denda }}','{{ $d->ket }}','{{ route('trsKembali.update', $d->id) }}')"
                                                class="bg-[#5A827E] hover:bg-[#4a6d69] text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                Edit
                                            </button>
                                            <button
                                                onclick="return deleteData('{{ $d->id }}','{{ $d->no_transaksi_kembali }}', '{{ route('trsKembali.destroy', $d->id) }}')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center p-4">Data Not Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="px-6">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ADD DATA --}}
    <div id="modal-addData" class="hidden fixed inset-0 flex justify-center items-center m-4 bg-black/30 z-50">
        <div
            class="bg-white dark:bg-gray-900 rounded-lg p-6 lg:w-4/12 w-full shadow-xl border border-green-600 overflow-auto max-h-[90vh]">
            <h2 class="text-lg font-bold mb-4 bg-green-100 text-green-900 p-2 rounded-xl">Tambah trsKembali</h2>
            <form id="addForm" action="{{ route('trsKembali.store') }}" method="post" class="w-full">
                @csrf
                <div id="modal-content"></div>
                <div class="flex justify-end gap-3 mt-4">
                    <button type="submit" id="submitAdd"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModalAdd(event)"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL UPDATE DATA --}}
    <div id="modal-updateData" class="hidden fixed inset-0 flex justify-center items-center m-4 bg-black/30 z-50">
        <div
            class="bg-white dark:bg-gray-900 rounded-lg p-6 lg:w-4/12 w-full shadow-xl border border-green-600 overflow-auto max-h-[90vh]">
            <h2 class="text-lg font-bold mb-4 bg-green-100 text-green-900 p-2 rounded-xl">Update trsKembali</h2>
            <form id="updateForm" action="" method="post" class="w-full">
                @csrf
                @method('PATCH')
                <div id="modal-content-update"></div>
                <div class="flex justify-end gap-3 mt-4">
                    <button type="submit" id="submitUpdate"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModalUpdate(event)"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE DATA --}}
    <div id="modal-deleteData" class="hidden fixed inset-0 flex justify-center items-center m-4 bg-black/30 z-50">
        <div
            class="bg-white dark:bg-gray-900 rounded-lg p-6 lg:w-4/12 w-full shadow-xl border border-red-600 max-h-[90vh] overflow-auto">
            <h2 class="text-lg font-bold mb-4 text-red-600">Konfirmasi Hapus</h2>
            <form id="deleteForm" action="" method="post" class="w-full">
                @csrf
                @method('DELETE')
                <p id="delete-message" class="mb-4 text-gray-800 dark:text-gray-200"></p>
                <div class="flex justify-end gap-2">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">Hapus</button>
                    <button type="button" onclick="closeModalDelete()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT MODAL ADD --}}
    <script>
        function addData() {
            const modalContent = document.getElementById("modal-content");
            modalContent.innerHTML = `
                <div class="mb-4 w-full">
                    <label for="kd_anggota"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Anggota <span
                            class="text-red-500">*</span></label>
                    <select id="kd_anggota" name="kd_anggota" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        <option value="" disabled selected>-- Pilih Anggota --</option>
                        @foreach ($anggota as $ang)
                            <option value="{{ $ang->kd_anggota }}">{{ $ang->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 w-full">
                    <label for="tg_pinjam"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam <span
                            class="text-red-500">*</span></label>
                    <input id="tg_pinjam" type="date" name="tg_pinjam" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="tg_bts_kembali"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Batas Kembali <span
                            class="text-red-500">*</span></label>
                    <input id="tg_bts_kembali" type="date" name="tg_bts_kembali" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="tg_kembali"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kembali <span
                            class="text-red-500">*</span></label>
                    <input id="tg_kembali" type="date" name="tg_kembali" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="kd_koleksi"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koleksi <span
                            class="text-red-500">*</span></label>
                    <select id="kd_koleksi" name="kd_koleksi" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        <option value="" disabled selected>-- Pilih Koleksi --</option>
                        @foreach ($koleksi as $kol)
                            <option value="{{ $kol->kd_koleksi }}">{{ $kol->judul }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 w-full">
                    <label for="denda"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Denda</label>
                    <input id="denda" type="number" name="denda" min="0"
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="ket"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                    <input id="ket" type="text" name="ket"
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>
            `;

            document.getElementById("modal-addData").classList.remove("hidden");
        }

        function closeModalAdd(e) {
            e.preventDefault();
            document.getElementById("modal-addData").classList.add("hidden");
            document.getElementById("modal-content").innerHTML = "";
            document.getElementById("addForm").reset();
        }
    </script>

    {{-- SCRIPT MODAL UPDATE --}}
    <script>
        function updateData(id, kd_anggota, tg_pinjam, tg_bts_kembali, tg_kembali, kd_koleksi, denda, ket, route) {
            const modalContentUpdate = document.getElementById("modal-content-update");
            modalContentUpdate.innerHTML = `
                <div class="mb-4 w-full">
                    <label for="kd_anggota_update"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Anggota <span
                            class="text-red-500">*</span></label>
                    <select id="kd_anggota_update" name="kd_anggota" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        @foreach ($anggota as $ang)
                            <option value="{{ $ang->kd_anggota }}" ${kd_anggota === "{{ $ang->kd_anggota }}" ? "selected" : ""}>{{ $ang->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 w-full">
                    <label for="tg_pinjam_update"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam <span
                            class="text-red-500">*</span></label>
                    <input id="tg_pinjam_update" type="date" name="tg_pinjam" value="${tg_pinjam}" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="tg_bts_kembali_update"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Batas Kembali <span
                            class="text-red-500">*</span></label>
                    <input id="tg_bts_kembali_update" type="date" name="tg_bts_kembali" value="${tg_bts_kembali}" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="tg_kembali_update"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kembali <span
                            class="text-red-500">*</span></label>
                    <input id="tg_kembali_update" type="date" name="tg_kembali" value="${tg_kembali}" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="kd_koleksi_update"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koleksi <span
                            class="text-red-500">*</span></label>
                    <select id="kd_koleksi_update" name="kd_koleksi" required
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        @foreach ($koleksi as $kol)
                            <option value="{{ $kol->kd_koleksi }}" ${kd_koleksi === "{{ $kol->kd_koleksi }}" ? "selected" : ""}>{{ $kol->judul }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 w-full">
                    <label for="denda_update"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Denda</label>
                    <input id="denda_update" type="number" name="denda" min="0" value="${denda}"
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>

                <div class="mb-4 w-full">
                    <label for="ket_update"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                    <input id="ket_update" type="text" name="ket" value="${ket}"
                        class="form-control w-full lg:w-[387px] p-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-900 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>
            `;

            // Set action URL for update form
            document.getElementById("updateForm").action = route;

            document.getElementById("modal-updateData").classList.remove("hidden");
        }

        function closeModalUpdate(e) {
            e.preventDefault();
            document.getElementById("modal-updateData").classList.add("hidden");
            document.getElementById("modal-content-update").innerHTML = "";
            document.getElementById("updateForm").reset();
        }
    </script>

    {{-- SCRIPT MODAL DELETE --}}
    <script>
        function deleteData(id, noTransaksi, route) {
            const modal = document.getElementById("modal-deleteData");
            const message = document.getElementById("delete-message");
            const form = document.getElementById("deleteForm");

            message.textContent = `Yakin ingin menghapus data trsKembali dengan nomor transaksi: ${noTransaksi}?`;
            form.action = route;

            modal.classList.remove("hidden");
        }

        function closeModalDelete() {
            const modal = document.getElementById("modal-deleteData");
            modal.classList.add("hidden");
            document.getElementById("deleteForm").reset();
            document.getElementById("delete-message").textContent = "";
        }
    </script>
</x-app-layout>