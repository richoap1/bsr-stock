<x-app-layout>
    <x-slot name="header">
        Pengambilan Alat
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
             <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($alats as $alat)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg flex flex-col justify-between">
                    {{-- Bagian Informasi Alat --}}
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $alat->nama_alat }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $alat->serial_number ?? 'Tanpa S/N' }}</p>
                        
                        <p class="mt-4 font-bold text-gray-700 dark:text-gray-300">Stok Tersedia: {{ $alat->jumlah }}</p>

                        <div class="mt-2 text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Kalibrasi Berlaku s/d:</span>
                            @if ($alat->tgl_kalibrasi_terakhir)
                                @php
                                    $expiryDate = $alat->tgl_kalibrasi_terakhir->addMonths(6);
                                @endphp
                                <span class="font-semibold {{ $expiryDate->isPast() ? 'text-red-600' : 'text-green-600 dark:text-green-400' }}">
                                    {{ $expiryDate->format('d M Y') }}
                                    @if($expiryDate->isPast())
                                        (Expired)
                                    @endif
                                </span>
                            @else
                                <span class="font-semibold text-gray-500 dark:text-gray-400">-</span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Bagian Form Pengambilan --}}
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50">
                        <form action="{{ route('pengambilan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="alat_id" value="{{ $alat->id }}">
                            
                            {{-- UPDATE 1: TAMBAHKAN INPUT KETERANGAN DI SINI --}}
                            <div class="mb-4">
                               <x-input-label for="keterangan_{{ $alat->id }}" class="sr-only">Keterangan</x-input-label>
                               <x-text-input id="keterangan_{{ $alat->id }}" class="block w-full text-sm" type="text" name="keterangan" placeholder="Keterangan (opsional)..." :value="old('keterangan')" />
                               <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                            </div>

                            {{-- UPDATE 2: Sesuaikan layout untuk jumlah dan tombol --}}
                            <div class="flex items-center gap-4">
                                <div class="flex-grow">
                                    <x-input-label for="jumlah_diambil_{{ $alat->id }}" class="sr-only">Jumlah</x-input-label>
                                    <x-text-input id="jumlah_diambil_{{ $alat->id }}" class="block w-full" type="number" name="jumlah_diambil" required min="1" max="{{ $alat->jumlah }}" placeholder="Jumlah"/>
                                </div>
                                <x-primary-button>
                                    {{ __('Ambil') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                     <p class="text-gray-500 dark:text-gray-400">Saat ini tidak ada alat yang tersedia untuk diambil.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>