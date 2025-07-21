<x-app-layout>
    <x-slot name="header">
        Tambah Alat Baru
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <form action="{{ route('admin.alat.store') }}" method="POST">
            @csrf
            @include('admin.alat._form')
        </form>
    </div>
</x-app-layout>