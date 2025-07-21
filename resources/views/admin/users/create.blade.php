<x-app-layout>
    <x-slot name="header">
        Tambah User Baru
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            @include('admin.users._form', ['user' => new \App\Models\User()])
        </form>
    </div>
</x-app-layout>