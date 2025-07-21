<x-app-layout>
    <x-slot name="header">
        Buat Permintaan Baru
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <form action="{{ route('permintaan.store') }}" method="POST" x-data="{ tipe: '{{ old('tipe_permintaan', 'barang') }}' }">
            @csrf
            
            <div class="mb-6">
                <x-input-label :value="__('Pilih Tipe Permintaan')" class="mb-2"/>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="tipe_permintaan" value="barang" x-model="tipe" class="text-indigo-600 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        <span class="ms-2 text-sm text-gray-700 dark:text-gray-300">Permintaan Barang</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="tipe_permintaan" value="uang" x-model="tipe" class="text-indigo-600 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        <span class="ms-2 text-sm text-gray-700 dark:text-gray-300">Permintaan Uang</span>
                    </label>
                </div>
            </div>

            <div class="space-y-6">
                
                {{-- MENGGUNAKAN <template x-if="..."> --}}
                <template x-if="tipe === 'barang'">
                    <div class="space-y-6">
                        {{-- Field untuk Nama Barang --}}
                        <div>
                            <x-input-label for="deskripsi_barang" :value="__('Nama Barang yang Diminta')" />
                            <x-text-input id="deskripsi_barang" class="block mt-1 w-full" type="text" name="deskripsi" :value="old('deskripsi')" />
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        {{-- Field untuk Deskripsi Tambahan / Spesifikasi --}}
                        <div>
                            <x-input-label for="keterangan_barang" :value="__('Spesifikasi / Deskripsi Tambahan (Opsional)')" />
                            <textarea id="keterangan_barang" name="keterangan" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        {{-- Field untuk Jumlah dan Harga --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah Barang')" />
                                <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" :value="old('jumlah')" />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="harga_barang" :value="__('Estimasi Harga Satuan (Opsional)')" />
                                <x-text-input id="harga_barang" class="block mt-1 w-full" type="number" name="harga_barang" :value="old('harga_barang')" step="0.01" />
                                <x-input-error :messages="$errors->get('harga_barang')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </template>
                
                {{-- MENGGUNAKAN <template x-if="..."> --}}
                <template x-if="tipe === 'uang'">
                     <div class="space-y-6">
                        <div>
                             <x-input-label for="deskripsi_uang" :value="__('Deskripsi / Keperluan Dana')" />
                             <x-text-input id="deskripsi_uang" class="block mt-1 w-full" type="text" name="deskripsi" :value="old('deskripsi')" />
                             <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nominal_uang" :value="__('Nominal Uang')" />
                                <x-text-input id="nominal_uang" class="block mt-1 w-full" type="number" name="nominal_uang" :value="old('nominal_uang')" step="0.01"/>
                                <x-input-error :messages="$errors->get('nominal_uang')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="mata_uang" :value="__('Mata Uang')" />
                                <select id="mata_uang" name="mata_uang" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="IDR" @selected(old('mata_uang') == 'IDR')>IDR (Rp)</option>
                                    <option value="USD" @selected(old('mata_uang') == 'USD')>USD ($)</option>
                                </select>
                                <x-input-error :messages="$errors->get('mata_uang')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <div class="mt-6">
                <x-input-label for="tanggal_permintaan" :value="__('Tanggal Permintaan')" />
                <x-text-input id="tanggal_permintaan" class="block mt-1 w-full" type="date" name="tanggal_permintaan" :value="old('tanggal_permintaan', date('Y-m-d'))" required />
                <x-input-error :messages="$errors->get('tanggal_permintaan')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                 <a href="{{ route('permintaan.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md">
                    Batal
                </a>
                <x-primary-button class="ms-4">
                    Ajukan Permintaan
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>