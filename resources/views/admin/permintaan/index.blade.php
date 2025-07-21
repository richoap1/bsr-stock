<x-app-layout>
    <x-slot name="header">
        Approval Permintaan
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Daftar Semua Permintaan</h3>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="mb-4">
            <form action="{{ route('admin.permintaan.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Filter Teks --}}
                    <div class="md:col-span-2">
                        <x-input-label for="search_permintaan" :value="__('Cari Deskripsi/Pemohon')" />
                        <x-text-input id="search_permintaan" type="text" name="search_permintaan" placeholder="Cari..." class="mt-1 block w-full" :value="request('search_permintaan')" />
                    </div>
                    {{-- Filter Tanggal --}}
                    <div>
                        <x-input-label for="filter_tanggal" :value="__('Tanggal Permintaan')" />
                        <x-text-input id="filter_tanggal" type="date" name="filter_tanggal" class="mt-1 block w-full" :value="request('filter_tanggal')" />
                    </div>
                    {{-- Filter Status --}}
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
                    <a href="{{ route('admin.permintaan.index') }}" class="ms-4 text-sm text-gray-500 hover:text-gray-800">Reset Filter</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @php
                            $sortBy = $sortBy ?? 'created_at';
                            $sortDirection = $sortDirection ?? 'desc';
                            $makeSortable = fn($field, $displayName) => '
                                <a href="'.route('admin.permintaan.index', array_merge(request()->query(), [
                                    'sort_by' => $field,
                                    'sort_direction' => ($sortBy == $field && $sortDirection == 'asc') ? 'desc' : 'asc'
                                ])).'" class="flex items-center">
                                    '.$displayName.'
                                    '.(($sortBy == $field) ? ($sortDirection == 'asc' ? ' &uarr;' : ' &darr;') : '').'
                                </a>';
                        @endphp
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makeSortable('deskripsi', 'Deskripsi Permintaan') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makeSortable('tipe_permintaan', 'Tipe') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makeSortable('tanggal_permintaan', 'Tgl Permintaan') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{!! $makeSortable('status', 'Status') !!}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($permintaans as $permintaan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $permintaan->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <div class="font-medium text-gray-800 dark:text-gray-200">{{ $permintaan->deskripsi }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($permintaan->keterangan)
                                        <span class="italic">"{{ $permintaan->keterangan }}"</span><br>
                                    @endif
                                    @if($permintaan->tipe_permintaan == 'barang')
                                        Jumlah: {{ $permintaan->jumlah }} Pcs
                                    @else
                                        {{ $permintaan->mata_uang }} {{ number_format($permintaan->nominal_uang, 0, ',', '.') }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $permintaan->tipe_permintaan == 'barang' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' }}">
                                    {{ ucfirst($permintaan->tipe_permintaan) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $permintaan->tanggal_permintaan->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClass = ['waiting' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300', 'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300', 'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$permintaan->status] }}">
                                    {{ ucfirst($permintaan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($permintaan->status == 'waiting')
                                    <form action="{{ route('admin.permintaan.approve', $permintaan) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-900">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.permintaan.reject', $permintaan) }}" method="POST" class="inline ml-4">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900">Reject</button>
                                    </form>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $permintaans->links() }}
        </div>
    </div>
</x-app-layout>