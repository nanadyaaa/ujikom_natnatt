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
                <input type="date" id="tgl_pinjam" name="tgl_pinjam" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" />
            </div>
            <div class="lg:mb-5 mb-2 w-full">
                <label for="tgl_bts_kembali" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Batas Kembali</label>
                <input type="date" id="tgl_bts_kembali" name="tgl_bts_kembali" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value=""/>
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

    // const maxBatasPinjam = @json($max_wkt_pjm);
    const inputTglPinjam = document.getElementById('tgl_pinjam');
    const inputTglBtsKembali = document.getElementById('tgl_bts_kembali');

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

    new TomSelect("#kd_anggota", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "Pilih Anggota"
    });

    new TomSelect("#kd_koleksi", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "Pilih Koleksi"
    });

}
</script>
@endpush