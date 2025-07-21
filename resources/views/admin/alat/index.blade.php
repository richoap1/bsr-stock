<x-app-layout>
    <x-slot name="header">
        Manajemen Alat
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Stok Alat</h3>
            <a href="{{ route('admin.alat.create') }}">
                <x-primary-button>{{ __('Tambah Alat Baru') }}</x-primary-button>
            </a>
        </div>
        
        <div class="mb-4">
            <form action="{{ route('admin.alat.index') }}" method="GET">
                <div class="flex items-center">
                    <x-text-input type="text" name="search" placeholder="Cari nama alat..." class="w-full md:w-1/3" :value="request('search')" />
                    <x-primary-button class="ms-2">Cari</x-primary-button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        @php
                            // PERBAIKAN: Set nilai default jika variabel tidak ada
                            $sortBy = $sortBy ?? 'created_at';
                            $sortDirection = $sortDirection ?? 'desc';

                            // Helper untuk membuat link sortable
                            $makeSortable = fn($field, $displayName) => '
                                <a href="'.route('admin.alat.index', [
                                    'search' => request('search'),
                                    'sort_by' => $field,
                                    'sort_direction' => ($sortBy == $field && $sortDirection == 'asc') ? 'desc' : 'asc'
                                ]).'" class="flex items-center">
                                    '.$displayName.'
                                    '.(($sortBy == $field) ? ($sortDirection == 'asc' ? ' &uarr;' : ' &darr;') : '').'
                                </a>';
                        @endphp
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{!! $makeSortable('nama_alat', 'Nama Alat') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Serial Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{!! $makeSortable('jumlah', 'Jumlah') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{!! $makeSortable('tgl_datang_alat', 'Tgl Datang') !!}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{!! $makeSortable('tgl_kalibrasi_terakhir', 'Kalibrasi Berlaku s/d') !!}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($alats as $alat)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $alat->nama_alat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $alat->serial_number ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $alat->jumlah }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($alat->tgl_datang_alat)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($alat->tgl_kalibrasi_terakhir)
                                    @php
                                        $expiryDate = $alat->tgl_kalibrasi_terakhir->addMonths(6);
                                    @endphp
                                    <span class="{{ $expiryDate->isPast() ? 'text-red-500 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $expiryDate->format('d M Y') }}
                                        @if($expiryDate->isPast())
                                            (Expired)
                                        @endif
                                    </span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.alat.edit', $alat) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('admin.alat.destroy', $alat) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900">Hapus</button>
                                </form>
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
            {{ $alats->links() }}
        </div>
    </div>
</x-app-layout>