<x-app-layout>
    <x-slot name="header">
        Riwayat Permintaan Saya
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Permintaan Anda</h3>
            <a href="{{ route('permintaan.create') }}">
                <x-primary-button>
                    {{ __('Buat Permintaan Baru') }}
                </x-primary-button>
            </a>
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deskripsi Permintaan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Permintaan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($permintaans as $permintaan)
                        <tr>
                            {{-- Kolom Deskripsi yang Dinamis --}}
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <div class="font-medium text-gray-800 dark:text-gray-200">
                                    @if($permintaan->tipe_permintaan == 'barang' && $permintaan->alat)
                                        {{ $permintaan->alat->nama_alat }}
                                    @else
                                        {{ $permintaan->deskripsi }}
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">
                                    @if($permintaan->tipe_permintaan == 'barang')
                                        Jumlah: {{ $permintaan->jumlah }} Pcs
                                    @else
                                        {{ $permintaan->mata_uang }} {{ number_format($permintaan->nominal_uang, 0, ',', '.') }}
                                    @endif
                                </div>
                            </td>

                            {{-- Kolom Tipe Permintaan --}}
                             <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $permintaan->tipe_permintaan == 'barang' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' }}">
                                    {{ ucfirst($permintaan->tipe_permintaan) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($permintaan->tanggal_permintaan)->format('d M Y') }}</td>
                            
                            {{-- Kolom Status --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                               @php
                                    $statusClass = [
                                        'waiting' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    ];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$permintaan->status] }}">
                                    {{ ucfirst($permintaan->status) }}
                                </span>
                            </td>
                            
                            {{-- Kolom Aksi untuk User --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($permintaan->status == 'waiting')
                                    <form action="{{ route('permintaan.destroy', $permintaan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900">Batalkan</button>
                                    </form>
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">Anda belum pernah membuat permintaan.</td>
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