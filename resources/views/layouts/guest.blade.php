<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Menyamakan format judul dengan layout utama --}}
        <title>{{ config('app.name', 'Laravel') }} - PT. BSR GLOBAL SURVEY</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-100 dark:bg-slate-900 transition-colors duration-300">
            
            {{-- Logo Perusahaan --}}
            <div class="mb-6">
                <a href="/">
                    <img src="{{ asset('images/logo-bsr.png') }}" alt="Logo PT. BSR GLOBAL SURVEY" class="w-20 h-20">
                </a>
            </div>

            {{-- Card untuk Form --}}
            <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-800 shadow-lg overflow-hidden sm:rounded-lg border-t-4 border-indigo-600 dark:border-indigo-500">
                {{ $slot }}
            </div>

            {{-- Footer Tambahan untuk Halaman Guest --}}
            <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                <p>© {{ date('Y') }} PT. BSR GLOBAL SURVEY</p>
            </div>
        </div>
    </body>
</html>