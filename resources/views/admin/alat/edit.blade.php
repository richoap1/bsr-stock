<x-app-layout>
    <x-slot name="header">
        Edit Data Alat: {{ $alat->nama_alat }}
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <form action="{{ route('admin.alat.update', $alat) }}" method="POST">
            @csrf
            @method('PATCH')
            {{-- File ini memuat form dan akan terisi otomatis dengan data $alat --}}
            @include('admin.alat._form', ['alat' => $alat])
        </form>
    </div>
</x-app-layout>