<x-app-layout>
    <x-slot name="header">
        Riwayat Transaksi
    </x-slot>

    {{-- TOMBOL DOWNLOAD DI SINI --}}
    <div class="p-6 pb-0">
        <div class="flex justify-end">
            <a href="{{ route('admin.riwayat.export') }}">
                <x-primary-button>
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Download Semua Riwayat (Excel)
                </x-primary-button>
            </a>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- == KARTU 1: RIWAYAT PENGAMBILAN ALAT == --}}
    {{-- ======================================================= --}}
    <div class="mb-8 p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Pengambilan Alat</h3>
    <div class="mb-4">
        <form action="{{ url()->current() }}" method="GET">
            <div class="flex items-center">
                <input type="hidden" name="search_permintaan" value="{{ request('search_permintaan') }}">
                <input type="hidden" name="filter_tanggal" value="{{ request('filter_tanggal') }}">
                <input type="hidden" name="filter_status" value="{{ request('filter_status') }}">
                <x-text-input type="text" name="search_pengambilan" placeholder="Cari nama alat atau pengambil..." class="w-full md:w-1/3" :value="request('search_pengambilan')" />
                <x-primary-button class="ms-2">Cari</x-primary-button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    @php
                        // Helper untuk tabel Pengambilan
                        $sortByPengambilan = $sortByPengambilan ?? 'tanggal_pengambilan';
                        $sortDirectionPengambilan = $sortDirectionPengambilan ?? 'desc';
                        $makePengambilanSortable = fn($field, $displayName) => '<a href="'.url()->current().'?'.http_build_query(array_merge(request()->except('sort_by_pengambilan', 'sort_direction_pengambilan'), ['sort_by_pengambilan' => $field,'sort_direction_pengambilan' => ($sortByPengambilan == $field && $sortDirectionPengambilan == 'asc') ? 'desc' : 'asc'])).'" class="flex items-center">'.$displayName.(($sortByPengambilan == $field) ? ($sortDirectionPengambilan == 'asc' ? ' &uarr;' : ' &darr;') : '').'</a>';
                    @endphp
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Alat</th>
                    {{-- UPDATE 1: TAMBAHKAN HEADER KOLOM KETERANGAN --}}
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{!! $makePengambilanSortable('jumlah_diambil', 'Jumlah Diambil') !!}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Diambil Oleh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{!! $makePengambilanSortable('tanggal_pengambilan', 'Waktu') !!}</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($riwayatPengambilan as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->alat->nama_alat }}</td>
                        {{-- UPDATE 2: TAMBAHKAN DATA KOLOM KETERANGAN --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->jumlah_diambil }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($item->tanggal_pengambilan)->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        {{-- UPDATE 3: SESUAIKAN COLSPAN MENJADI 5 --}}
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat pengambilan alat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $riwayatPengambilan->links() }}
    </div>
</div>
    {{-- ======================================================= --}}
    {{-- == KARTU 2: RIWAYAT PERMINTAAN BARANG/UANG == --}}
    {{-- ======================================================= --}}
    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Riwayat Permintaan Barang/Uang</h3>

        <div class="mb-4">
            <form action="{{ url()->current() }}" method="GET">
                 <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="hidden" name="search_pengambilan" value="{{ request('search_pengambilan') }}">
                    <div class="md:col-span-2">
                        <x-input-label for="search_permintaan" :value="__('Cari Deskripsi/Pemohon')" />
                        <x-text-input id="search_permintaan" type="text" name="search_permintaan" placeholder="Cari..." class="mt-1 block w-full" :value="request('search_permintaan')" />
                    </div>
                    <div>
                        <x-input-label for="filter_tanggal" :value="__('Tanggal Permintaan')" />
                        <x-text-input id="filter_tanggal" type="date" name="filter_tanggal" class="mt-1 block w-full" :value="request('filter_tanggal')" />
                    </div>
                    <div>
                        <x-input-label for="filter_status" :value="__('Status')" />
                        <select id="filter_status" name="filter_status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="waiting" @selected(request('filter_status') == 'waiting')>Waiting</option>
                            <option value="approved" @selected(request('filter_status') == 'approved')>Approved</option>
                            <option value="rejected" @selected(request('filter_status') == 'rejected')>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center mt-4">
                    <x-primary-button>Terapkan Filter</x-primary-button>
                    <a href="{{ url()->current() }}" class="ms-4 text-sm text-gray-500 hover:text-gray-800">Reset Filter</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @php
                            $sortByPermintaan = $sortByPermintaan ?? 'tanggal_permintaan';
                            $sortDirectionPermintaan = $sortDirectionPermintaan ?? 'desc';
                            $makePermintaanSortable = fn($field, $displayName) => '<a href="'.url()->current().'?'.http_build_query(array_merge(request()->except('sort_by_permintaan', 'sort_direction_permintaan'), ['sort_by_permintaan' => $field,'sort_direction_permintaan' => ($sortByPermintaan == $field && $sortDirectionPermintaan == 'asc') ? 'desc' : 'asc'])).'" class="flex items-center">'.$displayName.(($sortByPermintaan == $field) ? ($sortDirectionPermintaan == 'asc' ? ' &uarr;' : ' &darr;') : '').'</a>';
                        @endphp
                        @if(request()->routeIs('admin.riwayat.index'))
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makePermintaanSortable('deskripsi', 'Deskripsi Permintaan') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makePermintaanSortable('tipe_permintaan', 'Tipe') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makePermintaanSortable('tanggal_permintaan', 'Tgl Permintaan') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makePermintaanSortable('status', 'Status') !!}</th>
                        @if(auth()->user()->role == 'admin')
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($riwayatPermintaan as $item)
                        <tr>
                            @if(request()->routeIs('admin.riwayat.index'))
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item->user->name }}</td>
                            @endif
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <div class="font-medium text-gray-800 dark:text-gray-200">{{ $item->deskripsi }}</div>
                                @if($item->keterangan)
                                <div class="mt-1 text-xs text-gray-500 italic">"{{ $item->keterangan }}"</div>
                                @endif
                                <div class="text-xs text-gray-500 mt-1">
                                    @if($item->tipe_permintaan == 'barang')
                                        Jumlah: {{ $item->jumlah }} Pcs
                                    @else
                                        {{ $item->mata_uang }} {{ number_format($item->nominal_uang, 0, ',', '.') }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->tipe_permintaan == 'barang' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' }}">
                                    {{ ucfirst($item->tipe_permintaan) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $item->tanggal_permintaan->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClass = ['waiting' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300','approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300','rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$item->status] }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            @if(auth()->user()->role == 'admin')
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($item->status == 'waiting')
                                    <form action="{{ route('permintaan.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900">Batalkan</button>
                                    </form>
                                @else
                                -
                                @endif
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            @php
                                $colspan = 4; // Kolom dasar untuk user biasa
                                if (request()->routeIs('admin.riwayat.index')) $colspan = 5; // Kolom untuk superadmin
                            @endphp
                            <td colspan="{{ $colspan }}" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada riwayat permintaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $riwayatPermintaan->links() }}
        </div>
    </div>
</x-app-layout>