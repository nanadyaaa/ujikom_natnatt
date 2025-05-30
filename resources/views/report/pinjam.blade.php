<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('trsPinjam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg  rounded-xl">
                <div class="px-4 py-4 flex justify-between items-center">
                    <div class="text-lg font-semibold text-[#5A827E] dark:text-[#5A827E]">Data Laporan Pinjam</div>
                    <button onclick="return filterData()"
                        class="bg-[#5A827E] hover:bg-[#4b6f6b] text-white px-4 py-2 rounded-md font-medium transition shadow">
                        Filter ReportPinjam
                    </button>
                </div>
                <div class="px-6 text-gray-900 dark:text-gray-100 mb-4 overflow-x-auto rounded-b-lg">
                    <table id="myDataTable" class="min-w-full border border-[#5A827E] dark:border-[#5A827E] table-auto rounded-lg">
                        <thead class="bg-[#5A827E] text-white rounded-t-lg">
                            <tr>
                                <th class="border border-[#5A827E] px-4 py-2">No</th>
                                <th class="border border-[#5A827E] px-4 py-2">No Transaksi Pinjam</th>
                                <th class="border border-[#5A827E] px-4 py-2">Kode Anggota</th>
                                <th class="border border-[#5A827E] px-4 py-2">Anggota</th>
                                <th class="border border-[#5A827E] px-4 py-2">Tanggal Pinjam</th>
                                <th class="border border-[#5A827E] px-4 py-2">Batas Pinjam</th>
                                <th class="border border-[#5A827E] px-4 py-2">Kode Koleksi</th>
                                <th class="border border-[#5A827E] px-4 py-2">Judul</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @if ($data->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 dark:text-gray-400 py-4 rounded-b-lg">
                                        Silakan pilih rentang tanggal terlebih dahulu
                                    </td>
                                </tr>
                            @else
                                @foreach ($data as $d)
                                    <tr class="hover:bg-[#cfe2df] dark:hover:bg-[#3b5956] transition">
                                        <td class="border border-[#cfe2df] px-4 py-2 text-center">{{ $no++ }}</td>
                                        <td class="border border-[#cfe2df] px-4 py-2">{{ $d->no_transaksi_pinjam }}</td>
                                        <td class="border border-[#cfe2df] px-4 py-2">{{ $d->kd_anggota }}</td>
                                        <td class="border border-[#cfe2df] px-4 py-2">{{ $d->anggota->nm_anggota }}</td>
                                        <td class="border border-[#cfe2df] px-4 py-2">{{ $d->tg_pinjam }}</td>
                                        <td class="border border-[#cfe2df] px-4 py-2">{{ $d->tgl_bts_kembali }}</td>
                                        <td class="border border-[#cfe2df] px-4 py-2">{{ $d->kd_koleksi }}</td>
                                        <td class="border border-[#cfe2df] px-4 py-2">{{ $d->koleksi->judul }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL FILTER DATA --}}
    <div id="modal-filterData"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-xl">
            <h2 class="text-lg font-bold mb-4 text-green-700 dark:text-green-400">Filter trsPinjam</h2>
            <form id="filterForm" action="{{ route('reportPinjam.index') }}" method="get" class="w-full">
                @csrf
                <div class="mb-5 w-full">
                    <label for="dari"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dari</label>
                    <input type="date" id="dari" name="dari"
                        class="bg-gray-50 border border-green-500 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-green-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>
                <div class="mb-5 w-full">
                    <label for="sampai"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sampai</label>
                    <input type="date" id="sampai" name="sampai"
                        class="bg-gray-50 border border-green-500 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-green-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" />
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold transition">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModalFilter()"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold transition">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT FILTER --}}
    <script>
        function filterData() {
            document.getElementById("modal-filterData").classList.remove("hidden");
        }
        function closeModalFilter() {
            document.getElementById("modal-filterData").classList.add("hidden");
        }
    </script>
</x-app-layout>
