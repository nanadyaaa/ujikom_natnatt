<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('trsPinjam') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden">
                {{-- Header Section --}}
                <div class="flex justify-between items-center px-6 py-4 border-b dark:border-gray-700 bg-[#84AE92] text-white">
                    <h2 class="text-xl font-semibold">📄 Data Transaksi Pinjam</h2>
                    <button
                        onclick="return addData()"
                        class="bg-white text-[#84AE92] hover:bg-gray-100 font-semibold py-2 px-4 rounded shadow transition duration-300 ease-in-out">
                        ➕ Pinjam Buku
                    </button>
                </div>

                {{-- Search and Show Data Controls --}}
                <div class="px-6 pt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="w-full md:w-3/3">
                        <input
                            type="text"
                            id="searchInput"
                            onkeyup="searchTable()"
                            placeholder="🔍 Cari berdasarkan nama anggota atau kode koleksi..."
                            class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#84AE92] focus:border-[#84AE92] dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="showData" class="text-sm font-medium dark:text-white">Tampilkan</label>
                        <select id="showData" onchange="showLimitedRows()"
                            class="px-2 py-1 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-[#84AE92] focus:border-[#84AE92]">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="1000">Semua</option>
                        </select>
                    </div>
                </div>

                {{-- Data Table --}}
                <div class="p-4 overflow-x-auto">
                    <table id="myDataTable" class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-left text-xs font-bold uppercase text-gray-600 dark:text-gray-300 tracking-wider">
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">No Transaksi</th>
                                <th class="px-4 py-2">Kode Anggota</th>
                                <th class="px-4 py-2">Nama Anggota</th>
                                <th class="px-4 py-2">Tanggal Pinjam</th>
                                <th class="px-4 py-2">Batas Pinjam</th>
                                <th class="px-4 py-2">Kode Koleksi</th>
                                <th class="px-4 py-2">Judul Koleksi</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Aksi</th> {{-- Added Aksi column header --}}
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php $no = 1; @endphp
                            @forelse ($data as $d)
                                <tr class="hover:bg-[#E6F0EE] dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $no++ }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->no_transaksi_pinjam }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->kd_anggota }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->anggota->nm_anggota }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->tg_pinjam }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->tgl_bts_kembali }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->kd_koleksi }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->koleksi->judul }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-100">{{ $d->status }}</td>
                                    <td class="px-4 py-2 flex space-x-2">
                                        @if (Auth::user()->role_id == 1)
                                            <div class="flex space-x-2">
                                                <button
                                                    onclick="return updateData('{{ $d->id }}','{{ $d->kd_anggota }}','{{ $d->tg_pinjam }}','{{ $d->tgl_bts_kembali }}','{{ $d->kd_koleksi }}','{{ $d->status }}','{{ route('trsPinjam.update', $d->id) }}')"
                                                    class="flex items-center gap-1 bg-[#5A827E] hover:bg-[#40615e] text-white px-3 py-1 rounded text-sm shadow transition duration-300 ease-in-out">
                                                    ✏ Edit
                                                </button>
                                                <button
                                                    onclick="return deleteData('{{ $d->id }}','{{ $d->no_transaksi_pinjam }}', '{{ route('trsPinjam.destroy', $d->id) }}')"
                                                    class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm shadow transition duration-300 ease-in-out">
                                                    🗑 Hapus
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-gray-500 italic">Tidak ada aksi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                        Data Not Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ADD DATA --}}
    <div id="modal-addData" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg my-10 mx-4 shadow-lg
                    overflow-y-auto max-h-[90vh]
                    [scrollbar-width:none] [-ms-overflow-style:none]
                    [&::-webkit-scrollbar]:hidden">
            <h2 class="text-lg font-bold mb-4 bg-[#E6F0EE] dark:bg-gray-700 p-2 rounded-xl text-gray-800 dark:text-white">Tambah Pinjam</h2>
            <form id="addForm" action="{{ route('trsPinjam.store') }}" method="post" class="w-full">
                @csrf
                <p id="modal-content"></p>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit" id="submitAdd" class="bg-[#84AE92] hover:bg-[#709C88] text-white px-4 py-2 rounded transition duration-300 ease-in-out">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModalAdd(event)"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition duration-300 ease-in-out">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL UPDATE DATA --}}
    <div id="modal-updateData" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 overflow-y-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-lg my-10 mx-4 shadow-lg
                    overflow-y-auto max-h-[90vh]
                    [scrollbar-width:none] [-ms-overflow-style:none]
                    [&::-webkit-scrollbar]:hidden">
            <h2 class="text-lg font-bold mb-4 bg-[#E6F0EE] dark:bg-gray-700 p-2 rounded-xl text-gray-800 dark:text-white">Update Pinjaman</h2>
            <form id="updateForm" action="" method="post" class="w-full">
                @csrf
                @method('PATCH')
                <p id="modal-content-update"></p>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="submit" id="submitUpdate" class="bg-[#84AE92] hover:bg-[#709C88] text-white px-4 py-2 rounded transition duration-300 ease-in-out">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModalUpdate(event)"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition duration-300 ease-in-out">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DELETE DATA --}}
    <div id="modal-deleteData" class="hidden fixed inset-0 flex justify-center items-center m-4 bg-black/30 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 lg:w-4/12 w-full shadow-xl">
            <h2 class="text-lg font-bold mb-4 text-red-600 dark:text-red-400">Konfirmasi Hapus</h2>
            <form id="deleteForm" action="" method="post" class="w-full">
                @csrf
                @method('DELETE')
                <p id="delete-message" class="mb-4 text-gray-800 dark:text-gray-200"></p>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition duration-300 ease-in-out">Hapus</button>
                    <button type="button" onclick="closeModalDelete()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition duration-300 ease-in-out">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT MODAL ADD --}}
    @push('scripts')
        <script>
            function addData() {
                const modalContent = document.getElementById("modal-content");
                modalContent.innerHTML = `
                    <div class="lg:mb-5 mb-2 w-full">
                        <label for="kd_anggota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Anggota <span class="text-red-500">*</span></label>
                        <select id="kd_anggota" name="kd_anggota" class="tom-select w-full" data-placeholder="Pilih Anggota">
                            <option value="">Pilih...</option>
                            @foreach ($anggota as $a)
                                <option value="{{ $a->kd_anggota }}">{{ $a->nm_anggota }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="lg:mb-5 mb-2 w-full">
                        <label for="tgl_pinjam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam</label>
                        <input type="date" id="tgl_pinjam" name="tgl_pinjam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#84AE92] focus:border-[#84AE92] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="" />
                    </div>
                    <div class="lg:mb-5 mb-2 w-full">
                        <label for="tgl_bts_kembali" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Batas Kembali</label>
                        <input type="date" id="tgl_bts_kembali" name="tgl_bts_kembali" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#84AE92] focus:border-[#84AE92] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value=""/>
                    </div>
                    <div class="lg:mb-5 mb-2 w-full">
                        <label for="kd_koleksi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koleksi <span class="text-red-500">*</span></label>
                        <select id="kd_koleksi" name="kd_koleksi" class="tom-select w-full" data-placeholder="Pilih Koleksi">
                            <option value="">Pilih...</option>
                            @foreach ($koleksi as $k)
                                <option value="{{ $k->kd_koleksi }}">{{ $k->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                `;

                const modal = document.getElementById("modal-addData");
                modal.classList.remove("hidden");

                // Pastikan ini tidak dikomentari
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
                    const formattedDate = `${yyyy}-${mm}-${dd}`;

                    inputTglBtsKembali.value = formattedDate;
                });

                // Inisialisasi TomSelect untuk modal addData (di luar event listener)
                new TomSelect("#kd_anggota", {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Pilih Anggota"
                });

                new TomSelect("#kd_koleksi", {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Pilih Koleksi"
                });
            }
        </script>
    @endpush

    <script>
        function closeModalAdd(event) {
            event.preventDefault();
            const modal = document.getElementById("modal-addData");
            modal.classList.add("hidden");
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById("addForm");
            form.addEventListener("submit", function (e) {
                const anggota = document.getElementById("kd_anggota").value.trim();
                const tglPinjam = document.getElementById("tgl_pinjam").value.trim();
                const tglBtsKembali = document.getElementById("tgl_bts_kembali").value.trim();
                const koleksi = document.getElementById("kd_koleksi").value.trim();

                if (!anggota || !tglPinjam || !tglBtsKembali || !koleksi) {
                    e.preventDefault(); // prevents form submission
                    // Mengganti alert dengan modal kustom atau pesan di UI
                    // alert("Harap lengkapi semua data terlebih dahulu!");
                    showCustomAlert("Harap lengkapi semua data terlebih dahulu!");
                }
            });
        });

        // Custom Alert Function (pengganti alert())
        function showCustomAlert(message) {
            // Buat elemen modal kustom
            const alertModal = document.createElement('div');
            alertModal.id = 'custom-alert-modal';
            alertModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40';
            alertModal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-sm shadow-xl text-center">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Peringatan!</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-6">${message}</p>
                    <button onclick="document.getElementById('custom-alert-modal').remove()"
                            class="bg-[#84AE92] hover:bg-[#709C88] text-white px-6 py-2 rounded transition duration-300 ease-in-out">
                        OK
                    </button>
                </div>
            `;
            document.body.appendChild(alertModal);
        }
    </script>


    {{-- SCRIPT MODAL UPDATE --}}
    <script>
        function updateData(id, kd_anggota, tg_pinjam, tgl_bts_kembali, kd_koleksi, status, routeUrl) {
            const modal = document.getElementById("modal-updateData");
            modal.classList.remove("hidden");

            const modalContent = document.getElementById("modal-content-update");
            modalContent.innerHTML = `
                <div class="lg:mb-5 mb-2 w-full">
                    <label for="kd_anggota_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Anggota <span class="text-red-500">*</span></label>
                    <select id="kd_anggota_update" name="kd_anggota" class="tom-select w-full" data-placeholder="Pilih Anggota">
                        @foreach ($anggota as $a)
                            <option value="{{ $a->kd_anggota }}" ${kd_anggota === "{{ $a->kd_anggota }}" ? 'selected' : ''}>{{ $a->nm_anggota }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:mb-5 mb-2 w-full">
                    <label for="tgl_pinjam_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pinjam</label>
                    <input type="date" id="tgl_pinjam_update" name="tgl_pinjam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#84AE92] focus:border-[#84AE92] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="${tg_pinjam}" />
                </div>
                <div class="lg:mb-5 mb-2 w-full">
                    <label for="tgl_bts_kembali_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Batas Kembali</label>
                    <input type="date" id="tgl_bts_kembali_update" name="tgl_bts_kembali" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#84AE92] focus:border-[#84AE92] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="${tgl_bts_kembali}"/>
                </div>
                <div class="lg:mb-5 mb-2 w-full">
                    <label for="kd_koleksi_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koleksi <span class="text-red-500">*</span></label>
                    <select id="kd_koleksi_update" name="kd_koleksi" class="tom-select w-full" data-placeholder="Pilih Koleksi">
                        <option value="">Pilih...</option>
                        @foreach ($koleksi as $k)
                            <option value="{{ $k->kd_koleksi }}" ${kd_koleksi === "{{ $k->kd_koleksi }}" ? 'selected' : ''}>{{ $k->judul }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="status_update" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <div class="relative w-full mb-2">
                    <select name="status" id="status_update" required
                        class="w-full px-4 py-2 rounded-md border border-[#5A827E] bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#84AE92] hover:border-[#40615e] hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] transition">
                        <option value="">Pilih...</option>
                        <option value="PENDING" ${status === "PENDING" ? 'selected' : ''}>Pending</option>
                        <option value="APPROVED" ${status === "APPROVED" ? 'selected' : ''}>Approved</option>
                        <option value="RETURNED" ${status === "RETURNED" ? 'selected' : ''}>Returned</option> {{-- Added RETURNED status --}}
                    </select>
                </div>
            `;
            const updateForm = document.getElementById("updateForm");
            updateForm.action = routeUrl;

            // Initialize status dropdown value
            document.getElementById('status_update').value = status;

            const maxBatasPinjam = @json($max_wkt_pjm);
            const inputTglPinjam = document.getElementById('tgl_pinjam_update');
            const inputTglBtsKembali = document.getElementById('tgl_bts_kembali_update');

            inputTglPinjam.addEventListener('change', function() {
                const tglPinjam = new Date(this.value);
                if (isNaN(tglPinjam)) return;

                tglPinjam.setDate(tglPinjam.getDate() + maxBatasPinjam);

                const yyyy = tglPinjam.getFullYear();
                const mm = String(tglPinjam.getMonth() + 1).padStart(2, '0');
                const dd = String(tglPinjam.getDate()).padStart(2, '0');
                const formattedDate = `${yyyy}-${mm}-${dd}`;

                inputTglBtsKembali.value = formattedDate;
            });

            // Initialize TomSelect for updateData modal
            new TomSelect("#kd_anggota_update", {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: "Pilih Anggota"
            });

            new TomSelect("#kd_koleksi_update", {
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: "Pilih Koleksi"
            });

            // Re-select TomSelect values after initialization
            // This is crucial because TomSelect replaces the original select element
            const tomSelectAnggota = document.querySelector('#kd_anggota_update').tomselect;
            if (tomSelectAnggota) {
                tomSelectAnggota.setValue(kd_anggota);
            }
            const tomSelectKoleksi = document.querySelector('#kd_koleksi_update').tomselect;
            if (tomSelectKoleksi) {
                tomSelectKoleksi.setValue(kd_koleksi);
            }
        }

        function closeModalUpdate(event) {
            event.preventDefault();
            document.getElementById("modal-updateData").classList.add("hidden");
        }
    </script>

    {{-- SCRIPT MODAL DELETE --}}
    <script>
        function deleteData(id, nama, routeUrl) {
            const modal = document.getElementById("modal-deleteData");
            modal.classList.remove("hidden");

            const message = document.getElementById("delete-message");
            message.textContent = `Apakah kamu yakin ingin menghapus trsPinjam dengan ID transaksi "${nama}"?`; // Changed to no_transaksi_pinjam for clarity

            const deleteForm = document.getElementById("deleteForm");
            deleteForm.action = routeUrl;
        }

        function closeModalDelete() {
            document.getElementById("modal-deleteData").classList.add("hidden");
        }
    </script>
    <script>
        function searchTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#tableBody tr");

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }

        function showLimitedRows() {
            const select = document.getElementById("showData");
            const limit = parseInt(select.value);
            const rows = document.querySelectorAll("#tableBody tr");

            rows.forEach((row, index) => {
                row.style.display = (limit === 1000 || index < limit) ? "" : "none";
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            showLimitedRows();
        });
    </script>
</x-app-layout>