<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        {{-- UPDATE 1: Meta Description untuk SEO --}}
        <meta name="description" content="Aplikasi Sistem Manajemen Stok & Permintaan untuk PT. BSR GLOBAL SURVEY.">

        <title>{{ config('app.name', 'Laravel') }} - PT. BSR GLOBAL SURVEY</title>

        {{-- UPDATE 2: Favicon untuk tab browser --}}
        <link rel="icon" href="{{ asset('images/logo-bsr.png') }}" type="image/png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{-- 
            UPDATE 3: Tambahkan kelas "flex" dan "flex-col" pada div pembungkus utama ini.
        --}}
        <div class="min-h-screen bg-slate-100 dark:bg-slate-900 flex flex-col transition-colors duration-300">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-slate-200 dark:border-slate-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            {{--
                UPDATE 4: Tambahkan kelas "flex-grow" pada tag <main> ini.
            --}}
            <main class="py-12 flex-grow">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{-- Slot utama untuk konten halaman --}}
                    {{ $slot }}
                </div>
            </main>

            <footer class="bg-white dark:bg-gray-800 border-t border-slate-200 dark:border-slate-700">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                        © {{ date('Y') }} PT. BSR GLOBAL SURVEY. All Rights Reserved.
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>