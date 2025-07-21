<div class="space-y-6">
    {{-- Field Nama Alat --}}
    <div>
        <x-input-label for="nama_alat" :value="__('Nama Alat')" />
        <x-text-input id="nama_alat" name="nama_alat" type="text" class="mt-1 block w-full" :value="old('nama_alat', $alat->nama_alat)" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('nama_alat')" />
    </div>

    {{-- Field Serial Number --}}
    <div>
        <x-input-label for="serial_number" :value="__('Serial Number (Opsional)')" />
        <x-text-input id="serial_number" name="serial_number" type="text" class="mt-1 block w-full" :value="old('serial_number', $alat->serial_number)" />
        <x-input-error class="mt-2" :messages="$errors->get('serial_number')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Field Jumlah --}}
        <div>
            <x-input-label for="jumlah" :value="__('Jumlah')" />
            <x-text-input id="jumlah" name="jumlah" type="number" class="mt-1 block w-full" :value="old('jumlah', $alat->jumlah)" required />
            <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
        </div>

        {{-- Field Tanggal Datang Alat --}}
        <div>
            <x-input-label for="tgl_datang_alat" :value="__('Tanggal Datang Alat')" />
            <input 
                id="tgl_datang_alat"
                name="tgl_datang_alat"
                type="date"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @if($alat->exists) bg-gray-100 dark:bg-gray-700 cursor-not-allowed @endif"
                value="{{ old('tgl_datang_alat', $alat->tgl_datang_alat ? $alat->tgl_datang_alat->format('Y-m-d') : '') }}"
                required
                @if($alat->exists) disabled @endif
            >
            @if($alat->exists)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tanggal datang tidak dapat diubah.</p>
            @endif
            <x-input-error :messages="$errors->get('tgl_datang_alat')" class="mt-2" />
        </div>
    </div>

    {{-- Field Tanggal Kalibrasi Terakhir --}}
    <div>
        <x-input-label for="tgl_kalibrasi_terakhir" :value="__('Tanggal Kalibrasi Terakhir (Opsional)')" />
        <input 
            id="tgl_kalibrasi_terakhir"
            name="tgl_kalibrasi_terakhir"
            type="date"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            value="{{ old('tgl_kalibrasi_terakhir', $alat->tgl_kalibrasi_terakhir ? $alat->tgl_kalibrasi_terakhir->format('Y-m-d') : '') }}"
        >
        <x-input-error :messages="$errors->get('tgl_kalibrasi_terakhir')" class="mt-2" />
    </div>
</div>

<div class="flex items-center justify-end mt-6">
    <a href="{{ route('admin.alat.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900">Batal</a>
    <x-primary-button class="ms-4">
        Simpan
    </x-primary-button>
</div>