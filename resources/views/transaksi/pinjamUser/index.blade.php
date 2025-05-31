<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('trsPinjam') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="px-4 py-4 flex justify-between items-center">
                    <div class="text-lg font-semibold text-green-800 dark:text-green-400">Data Transaksi Pinjam</div>
                    <button onclick="addData()"
                        class="bg-[#5A827E] hover:bg-[#4a6d69] text-white px-4 py-2 rounded-md shadow-sm transition duration-300">
                        Tambah trsPinjam
                    </button>
                </div>
                <div class="overflow-hidden rounded-xl shadow">
                    <table class="min-w-full table-auto border-collapse text-sm border border-[#5A827E] rounded-xl">
                        <thead class="bg-[#5A827E] text-white">
                            <tr>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">No</th>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">No Transaksi Pinjam</th>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">Kode Anggota</th>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">Anggota</th>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">Tanggal Pinjam</th>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">Batas Pinjam</th>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">Kode Koleksi</th>
                                <th class="border border-[#5A827E] px-3 py-2 text-left">Judul</th>
                                {{-- Kolom Status dan Aksi harus selalu ada di tampilan Admin --}}
                                <th class="border border-[#5A827E] px-3 py-2 text-center">Status</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                            @php $no = 1; @endphp
                            @forelse ($data as $d)
                                <tr class="hover:bg-[#cfe2df] dark:hover:bg-[#3b5956] transition">
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $no++ }}</td>
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $d->no_transaksi_pinjam }}</td>
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $d->kd_anggota }}</td>
                                    {{-- Menggunakan null coalescing operator untuk mencegah error jika relasi tidak ditemukan --}}
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $d->anggota->nm_anggota ?? 'N/A' }}</td>
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $d->tg_pinjam }}</td>
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $d->tgl_bts_kembali }}</td>
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $d->kd_koleksi }}</td>
                                    {{-- Menggunakan null coalescing operator untuk mencegah error jika relasi tidak ditemukan --}}
                                    <td class="border border-[#cfe2df] px-3 py-2">{{ $d->koleksi->judul ?? 'N/A' }}</td>
                                    
                                    
                                </tr>
                            @empty
                                <tr>
                                    {{-- Sesuaikan colspan dengan jumlah kolom total (10 kolom) --}}
                                    <td colspan="10" class="text-center py-4 text-gray-600 dark:text-gray-400">Data Not Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ADD DATA --}}
    <div id="modal-addData" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-xl w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4 bg-amber-100 p-3 rounded-lg text-gray-800 dark:text-gray-900">Add
                trsPinjam</h2>
            <form id="addForm" action="{{ route('trsPinjam.store') }}" method="post" class="space-y-4">
                @csrf
                <div id="modal-content"></div>
                <div class="flex justify-end gap-3">
                    <button type="submit" id="submitAdd"
                        class="bg-green-700 hover:bg-green-600 text-white px-5 py-2 rounded-md">Simpan</button>
                    <button type="button" onclick="closeModalAdd()"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL UPDATE DATA --}}
    <div id="modal-updateData" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-xl w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4 bg-amber-100 p-3 rounded-lg text-gray-800 dark:text-gray-900">Update
                trsPinjam</h2>
            <form id="updateForm" action="" method="post" class="space-y-4">
                @csrf
                @method('PATCH')
                <div id="modal-content-update"></div>
                <div class="flex justify-end gap-3">
                    <button type="submit" id="submitUpdate"
                        class="bg-green-700 hover:bg-green-600 text-white px-5 py-2 rounded-md">Simpan</button>
                    <button type="button" onclick="closeModalUpdate(event)"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE DATA --}}
    <div id="modal-deleteData" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-xl w-full max-w-md">
            <h2 class="text-lg font-bold mb-4 text-red-600">Konfirmasi Hapus</h2>
            <form id="deleteForm" action="" method="post" class="space-y-4">
                @csrf
                @method('DELETE')
                <p id="delete-message" class="text-gray-800 dark:text-gray-100"></p>
                <div class="flex justify-end gap-3">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md">Hapus</button>
                    <button type="button" onclick="closeModalDelete()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT MODAL ADD --}}
    <script>
        function addData() {
            const modalContent = document.getElementById("modal-content");
            modalContent.innerHTML = `
                <div>
                    <label for="kd_anggota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Anggota <span class="text-red-500">*</span></label>
                    <select id="kd_anggota" name="kd_anggota" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih...</option>
                        @foreach ($anggota as $a)
                            <option value="{{ $a->kd_anggota }}">{{ $a->nm_anggota }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tgl_pinjam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam</label>
                    <input type="date" id="tgl_pinjam" name="tgl_pinjam" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
                <div>
                    <label for="tgl_bts_kembali" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Batas Kembali</label>
                    <input type="date" id="tgl_bts_kembali" name="tgl_bts_kembali" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
                <div>
                    <label for="kd_koleksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koleksi <span class="text-red-500">*</span></label>
                    <select id="kd_koleksi" name="kd_koleksi" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih...</option>
                        @foreach ($koleksi as $k)
                            <option value="{{ $k->kd_koleksi }}">{{ $k->judul }}</option>
                        @endforeach
                    </select>
                </div>
            `;
            document.getElementById("modal-addData").classList.remove("hidden");

            const maxBatasPinjam = @json($max_wkt_pjm);
            const inputTglPinjam = document.getElementById('tgl_pinjam');
            const inputTglBtsKembali = document.getElementById('tgl_bts_kembali');

            inputTglPinjam.addEventListener('change', function () {
                const tglPinjam = new Date(this.value);
                if (isNaN(tglPinjam)) return;

                tglPinjam.setDate(tglPinjam.getDate() + maxBatasPinjam);

                const yyyy = tglPinjam.getFullYear();
                const mm = String(tglPinjam.getMonth() + 1).padStart(2, '0');
                const dd = String(tglPinjam.getDate()).padStart(2, '0');
                inputTglBtsKembali.value = `${yyyy}-${mm}-${dd}`;
            });
        }

        function closeModalAdd() {
            document.getElementById("modal-addData").classList.add("hidden");
        }
    </script>

    {{-- SCRIPT MODAL UPDATE --}}
    <script>
        // Tambahkan 'status' sebagai parameter
        function updateData(id, kd_anggota, tg_pinjam, tgl_bts_kembali, kd_koleksi, status, routeUrl) {
            const modalContent = document.getElementById("modal-content-update");
            modalContent.innerHTML = `
                <div>
                    <label for="kd_anggota_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Anggota <span class="text-red-500">*</span></label>
                    <select id="kd_anggota_update" name="kd_anggota" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih...</option>
                        @foreach ($anggota as $a)
                            <option value="{{ $a->kd_anggota }}">{{ $a->nm_anggota }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tgl_pinjam_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam</label>
                    <input type="date" id="tgl_pinjam_update" name="tgl_pinjam" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
                <div>
                    <label for="tgl_bts_kembali_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Batas Kembali</label>
                    <input type="date" id="tgl_bts_kembali_update" name="tgl_bts_kembali" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
                <div>
                    <label for="kd_koleksi_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koleksi <span class="text-red-500">*</span></label>
                    <select id="kd_koleksi_update" name="kd_koleksi" class="w-full rounded border border-gray-300 p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Pilih...</option>
                        @foreach ($koleksi as $k)
                            <option value="{{ $k->kd_koleksi }}">{{ $k->judul }}</option>
                        @endforeach
                    </select>
                </div>

            `;
            
            // Set values after elements are created
            document.getElementById('kd_anggota_update').value = kd_anggota;
            document.getElementById('tgl_pinjam_update').value = tg_pinjam;
            document.getElementById('tgl_bts_kembali_update').value = tgl_bts_kembali;
            document.getElementById('kd_koleksi_update').value = kd_koleksi;
            document.getElementById('status_update').value = status; // Set nilai status

            const updateForm = document.getElementById("updateForm");
            updateForm.action = routeUrl;
            document.getElementById("modal-updateData").classList.remove("hidden");

            // Re-attach event listener for tgl_pinjam_update if needed for max_wkt_pjm calculation
            const maxBatasPinjam = @json($max_wkt_pjm);
            const inputTglPinjamUpdate = document.getElementById('tgl_pinjam_update');
            const inputTglBtsKembaliUpdate = document.getElementById('tgl_bts_kembali_update');

            inputTglPinjamUpdate.addEventListener('change', function () {
                const tglPinjam = new Date(this.value);
                if (isNaN(tglPinjam)) return;

                tglPinjam.setDate(tglPinjam.getDate() + maxBatasPinjam);

                const yyyy = tglPinjam.getFullYear();
                const mm = String(tglPinjam.getMonth() + 1).padStart(2, '0');
                const dd = String(tglPinjam.getDate()).padStart(2, '0');
                inputTglBtsKembaliUpdate.value = `${yyyy}-${mm}-${dd}`;
            });
        }

        function closeModalUpdate(e) {
            e.preventDefault();
            document.getElementById("modal-updateData").classList.add("hidden");
        }
    </script>

    {{-- SCRIPT MODAL DELETE --}}
    <script>
        function deleteData(id, nama, routeUrl) {
            const deleteForm = document.getElementById("deleteForm");
            deleteForm.action = routeUrl;
            document.getElementById("delete-message").textContent = `Apakah anda yakin ingin menghapus trsPinjam dengan nomor transaksi: "${nama}" ?`;
            document.getElementById("modal-deleteData").classList.remove("hidden");
        }

        function closeModalDelete() {
            document.getElementById("modal-deleteData").classList.add("hidden");
        }
    </script>
</x-app-layout>
```

**Setelah Anda melakukan langkah `dd($data->toArray());` dan melaporkan hasilnya, kita bisa melanjutkan untuk menyelesaikan masalah ini sepenuhnya