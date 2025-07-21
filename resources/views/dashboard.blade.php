<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-lg font-medium">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Anda login sebagai <span class="font-semibold">{{ ucfirst(Auth::user()->role) }}</span>. Gunakan menu di bawah untuk memulai.</p>
        </div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">


        @if(auth()->user()->role == 'superadmin')
            <a href="{{ route('admin.alat.index') }}" class="group block p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg shadow-sm transition-all duration-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                           <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5l.415-.207a.75.75 0 011.085.67V10.5m0 0h6m-6 0a.75.75 0 001.085.67l.415-.207M3 7.5V7.5c0-1.105 1.12-2.002 2.487-2.002h.025a2.25 2.25 0 012.25 2.25v.002c0 1.105-1.12 2.002-2.487 2.002h-.025a2.25 2.25 0 01-2.25-2.25v-.002zM3 16.5V16.5c0-1.105 1.12-2.002 2.487-2.002h.025a2.25 2.25 0 012.25 2.25v.002c0 1.105-1.12 2.002-2.487 2.002h-.025a2.25 2.25 0 01-2.25-2.25v-.002zM9 7.5h1.138c1.386 0 2.5 1.105 2.5 2.488v.001c0 1.383-1.114 2.488-2.5 2.488H9v-5zM15 7.5h1.138c1.386 0 2.5 1.105 2.5 2.488v.001c0 1.383-1.114 2.488-2.5 2.488H15v-5z" /></svg>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manajemen Alat</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Tambah, edit, dan hapus data alat inventaris.</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.permintaan.index') }}" class="group block p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg shadow-sm transition-all duration-200">
                <div class="flex items-start">
                     <div class="flex-shrink-0">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                           <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Approval Permintaan</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Setujui atau tolak permintaan barang dan uang.</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.riwayat.index') }}" class="group block p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg shadow-sm transition-all duration-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                           <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Semua Riwayat</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Lihat seluruh riwayat permintaan dan pengambilan.</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}" class="group block p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg shadow-sm transition-all duration-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.952a4.5 4.5 0 014.5 0m-4.5 0a4.5 4.5 0 00-4.5 0m3.75-9a15.048 15.048 0 017.5 0m-7.5 0a15.048 15.048 0 00-7.5 0M9 17.25m9-9c3.314 0 6 2.686 6 6s-2.686 6-6 6-6-2.686-6-6 2.686-6 6-6zM9 9c3.314 0 6 2.686 6 6s-2.686 6-6 6-6-2.686-6-6 2.686-6 6-6z" /></svg>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manajemen User</h4>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Tambah, edit, atau hapus akun pengguna.</p>
                    </div>
                </div>
            </a>
        @endif


        
        <a href="{{ route('permintaan.create') }}" class="group block p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg shadow-sm transition-all duration-200">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                       <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    </div>
                </div>
                <div class="ms-4">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Buat Permintaan Baru</h4>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ajukan permintaan untuk barang atau uang.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('pengambilan.index') }}" class="group block p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg shadow-sm transition-all duration-200">
            <div class="flex items-start">
                 <div class="flex-shrink-0">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                       <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l1.823-6.84a1.125 1.125 0 00-1.087-1.352H6.455c-.51 0-.955.343-1.087.835L3.25 14.25z" /></svg>
                    </div>
                </div>
                <div class="ms-4">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pengambilan Alat</h4>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ambil alat dari inventaris yang tersedia.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('riwayat.user') }}" class="group block p-6 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg shadow-sm transition-all duration-200">
            <div class="flex items-start">
                 <div class="flex-shrink-0">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                       <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </div>
                </div>
                <div class="ms-4">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Aktivitas Saya</h4>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Lihat semua riwayat permintaan dan pengambilan Anda.</p>
                </div>
            </div>
        </a>

    </div>

</x-app-layout>