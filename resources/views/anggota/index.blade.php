<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-200 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg  overflow-hidden">
                <div class="flex justify-between items-center px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 tracking-wide">Data Anggota</h3>
                    <button onclick="return addData()"
                        class="bg-[#5A827E] hover:bg-[#A4C494] text-gray-200 font-medium px-5 py-2 g shadow-md transition duration-300">
                        Tambah Anggota
                    </button>
                </div>
                <form method="GET" action="{{ route('anggota.index') }}" class="px-6 py-4 flex justify-end">
                    <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau kode anggota..."
                        class="border border-gray-300 px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" />
                    <button type="submit"
                        class="bg-[#B9D4AA] hover:bg-[#A4C494] text-gray-800 font-medium px-4 py-2  transition duration-300">
                        Cari
                    </button>
                </form>

                <div class="overflow-x-auto mx-auto" style="max-width: 95%; margin-top: 1rem;">
                    <table id="myDataTable"
                        class="min-w-full table-auto border border-gray-300 dark:border-gray-600 text-sm text-gray-800 dark:text-gray-200  overflow-hidden">
                        <!-- THEAD -->
                        <thead style="background-color: #5A827E;" class="text-white">
                            <tr>
                                @php
// Ambil parameter sort_kode dari request
$currentSort = request('sort_kode', 'asc');
// Toggle arah sort untuk klik berikutnya
$nextSort = $currentSort === 'asc' ? 'desc' : 'asc';

// Untuk menandai panah naik/turun
$arrow = $currentSort === 'asc' ? '▲' : '▼';
                                @endphp
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left ">No</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left cursor-pointer select-none"
                                    onclick="window.location.href='{{ route('anggota.index', array_merge(request()->except('page'), ['sort_kode' => $nextSort])) }}'">
                                    <div class="flex justify-between items-center w-full">
                                        <span>Kode</span>
                                        {!! request()->has('sort_kode') ? "<span class='text-sm ml-2'>{$arrow}</span>" : '' !!}
                                    </div>
                                </th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Nama</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Jenis Kelamin</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Alamat</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Status</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-left">Role</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center">Jumlah Pinjam</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <!-- TBODY -->
                        <tbody>
                            @php $no = ($data->currentPage() - 1) * $data->perPage() + 1; @endphp
                            @forelse ($data as $d)
                                <tr class="hover:bg-[#B9D4AA] transition duration-150">
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $no++ }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $d->kd_anggota }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $d->nm_anggota }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                        {{ $d->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600 max-w-xs truncate">{{ $d->alamat }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $d->status }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ $d->role->role_name }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center">{{ $d->jml_pinjam }}</td>
                                    <td class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-center space-x-2">
                                        <button
                                            onclick="return updateData('{{ $d->id }}','{{ $d->nm_anggota }}','{{ $d->jk }}','{{ $d->alamat }}','{{ $d->status }}','{{ route('anggota.update', $d->id) }}')"
                                            class="text-yellow-500 hover:text-yellow-600 transition">✏️</button>
                                        <button
                                            onclick="return deleteData('{{ $d->id }}','{{ $d->nm_anggota }}','{{ route('anggota.destroy', $d->id) }}')"
                                            class="text-red-600 hover:text-red-700 transition">❌</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-500 italic border border-gray-300 dark:border-gray-600 py-3">
                                        Data tidak ditemukan
                                    </td>
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
        <div class="bg-white dark:bg-gray-900 rounded-xl p-6 w-full max-w-md shadow-lg border border-[#5A827E]">
            <h2 class="text-xl font-semibold text-[#5A827E] dark:text-green-400 mb-5">Tambah Anggota</h2>
            <form id="addForm" action="{{ route('anggota.store') }}" method="post" class="space-y-4">
                @csrf
                <div id="modal-content"></div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="submit"
                        class="bg-[#5A827E] hover:bg-[#4b6f6b] text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModalAdd()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md font-medium transition-shadow shadow-sm">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
      

    {{-- Modal Update --}}
    <div id="modal-updateData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md shadow-xl">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Update Anggota</h2>
            <form id="updateForm" method="post">
                @csrf
                @method('PATCH')
                <div id="modal-content-update"></div>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="submit"
                        class="bg-[#5A827E] hover:bg-[#4b6f6b] text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="closeModalUpdate(event)"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="modal-deleteData" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md shadow-xl">
            <h2 class="text-lg font-bold text-5A827E mb-4">Konfirmasi Hapus</h2>
            <form id="deleteForm" method="post">
                @csrf
                @method('DELETE')
                <p id="delete-message" class="mb-4 text-gray-800 dark:text-gray-100"></p>
                <div class="flex justify-end gap-2">
                    <button type="submit"
                        class="bg-[#5A827E] hover:bg-[#4b6f6b]0 text-white px-4 py-2 rounded">Hapus</button>
                    <button type="button" onclick="closeModalDelete()"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        const kodeAnggotaBaru = @json($codeData);

        function addData() {
            const modalContent = document.getElementById("modal-content");
            modalContent.innerHTML = `
                <label>Kode Anggota</label>
                <input type="text" name="kd_anggota" class="input w-full mb-2" value="${kodeAnggotaBaru}" readonly />
                <label>Nama Anggota</label>
                <input type="text" name="nm_anggota" class="input w-full mb-2" required />
                <label>Jenis Kelamin</label>
                <div x-data="{ open: false, selected: '', value: '' }" class="relative w-full mb-2">
                    <input type="hidden" name="jk" x-model="value" required>

                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 rounded-md border border-[#5A827E] bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#5A827E] hover:border-[#40615e] hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] transition text-left">
                        <span x-text="selected || 'Pilih...'"></span>
                        <svg class="w-4 h-4 float-right mt-1 text-[#5A827E]" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" @click.outside="open = false"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-900 border border-[#5A827E] rounded-md shadow-lg">
                        <li @click="selected = 'Laki-laki'; value = 'L'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">Laki-laki</li>
                        <li @click="selected = 'Perempuan'; value = 'P'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">Perempuan</li>
                    </ul>
                </div>
                <label>Alamat</label>
                <textarea name="alamat" class="input w-full mb-2"></textarea>
                <label>Status</label>
                <div x-data="{ open: false, selected: '', value: '' }" class="relative w-full mb-2">
                    <input type="hidden" name="status" x-model="value" required>

                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 rounded-md border border-[#5A827E] bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#5A827E] hover:border-[#40615e] hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] transition text-left">
                        <span x-text="selected || 'Pilih...'"></span>
                        <svg class="w-4 h-4 float-right mt-1 text-[#5A827E]" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" @click.outside="open = false"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-900 border border-[#5A827E] rounded-md shadow-lg">
                        <li @click="selected = 'AKTIF'; value = 'AKTIF'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">AKTIF</li>
                        <li @click="selected = 'TIDAK AKTIF'; value = 'TIDAK AKTIF'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">TIDAK AKTIF</li>
                    </ul>
                </div>
                <label>Role</label>
                <div x-data="{ open: false, selected: '', value: '' }" class="relative w-full mb-2">
                    <input type="hidden" name="role_id" x-model="value" required>
                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 rounded-md border border-[#5A827E] bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#5A827E] hover:border-[#40615e] hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] transition text-left">
                        <span x-text="selected || 'Pilih Role...'"></span>
                        <svg class="w-4 h-4 float-right mt-1 text-[#5A827E]" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul x-show="open" @click.outside="open = false"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-900 border border-[#5A827E] rounded-md shadow-lg max-h-40 overflow-auto">
                        @foreach ($roles as $role)
                            <li @click="selected = '{{ $role->role_name }}'; value = '{{ $role->id }}'; open = false"
                                class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">{{ $role->role_name }}</li>
                        @endforeach
                    </ul>
                </div>


            `;
            document.getElementById("modal-addData").classList.remove("hidden");
        }

        function closeModalAdd() {
            document.getElementById("modal-addData").classList.add("hidden");
        }

        function updateData(id, nama, jk, alamat, status, routeUrl) {
            document.getElementById("modal-content-update").innerHTML = `
                <label>Nama Anggota</label>
                <input type="text" name="nm_anggota" class="input w-full mb-2" value="${nama}" required />
                 <label>Jenis Kelamin</label>
                <div x-data="{ open: false, selected: '', value: '' }" class="relative w-full mb-2">
                    <input type="hidden" name="jk" x-model="value" required>

                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 rounded-md border border-[#5A827E] bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#5A827E] hover:border-[#40615e] hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] transition text-left">
                        <span x-text="selected || 'Pilih...'"></span>
                        <svg class="w-4 h-4 float-right mt-1 text-[#5A827E]" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" @click.outside="open = false"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-900 border border-[#5A827E] rounded-md shadow-lg">
                        <li @click="selected = 'Laki-laki'; value = 'L'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">Laki-laki</li>
                        <li @click="selected = 'Perempuan'; value = 'P'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">Perempuan</li>
                    </ul>
                </div>
                <label>Alamat</label>
                <textarea name="alamat" class="input w-full mb-2">${alamat}</textarea>
                <label>Status</label>
                <div x-data="{ open: false, selected: '', value: '' }" class="relative w-full mb-2">
                    <input type="hidden" name="status" x-model="value" required>

                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 rounded-md border border-[#5A827E] bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#5A827E] hover:border-[#40615e] hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] transition text-left">
                        <span x-text="selected || 'Pilih...'"></span>
                        <svg class="w-4 h-4 float-right mt-1 text-[#5A827E]" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <ul x-show="open" @click.outside="open = false"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-900 border border-[#5A827E] rounded-md shadow-lg">
                        <li @click="selected = 'AKTIF'; value = 'AKTIF'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">AKTIF</li>
                        <li @click="selected = 'TIDAK AKTIF'; value = 'TIDAK AKTIF'; open = false"
                            class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">TIDAK AKTIF</li>
                    </ul>
                </div>
                <label>Role</label>
                <div x-data="{ open: false, selected: '', value: '' }" class="relative w-full mb-2">
                    <input type="hidden" name="role_id" x-model="value" required>
                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 rounded-md border border-[#5A827E] bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#5A827E] hover:border-[#40615e] hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] transition text-left">
                        <span x-text="selected || 'Pilih Role...'"></span>
                        <svg class="w-4 h-4 float-right mt-1 text-[#5A827E]" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul x-show="open" @click.outside="open = false"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-900 border border-[#5A827E] rounded-md shadow-lg max-h-40 overflow-auto">
                        @foreach ($roles as $role)
                            <li @click="selected = '{{ $role->role_name }}'; value = '{{ $role->id }}'; open = false"
                                class="px-4 py-2 hover:bg-[#e6f0ee] dark:hover:bg-[#3b5956] cursor-pointer transition">{{ $role->role_name }}</li>
                        @endforeach
                    </ul>
                </div>

            `;
            const updateForm = document.getElementById("updateForm");
            updateForm.action = routeUrl;
            document.getElementById("modal-updateData").classList.remove("hidden");
        }

        function closeModalUpdate(event) {
            event.preventDefault();
            document.getElementById("modal-updateData").classList.add("hidden");
        }

        function deleteData(id, nama, routeUrl) {
            const deleteMessage = document.getElementById("delete-message");
            deleteMessage.textContent = `Apakah Anda yakin ingin menghapus data anggota "${nama}"?`;
            const deleteForm = document.getElementById("deleteForm");
            deleteForm.action = routeUrl;
            document.getElementById("modal-deleteData").classList.remove("hidden");
        }

        function closeModalDelete() {
            document.getElementById("modal-deleteData").classList.add("hidden");
        }
    </script>
    <script>
        const searchInput = document.getElementById('search-input');

        searchInput.addEventListener('input', function () {
            if (this.value.trim() === '') {
                window.location.href = "{{ route('anggota.index') }}";
            }
        });
    </script>
</x-app-layout>