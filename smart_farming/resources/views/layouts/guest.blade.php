<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#2D6A4F">
    <title>{{ config('app.name', 'AgroPredict') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background:#F9FAFB;">
    <div class="min-h-screen flex">

        {{-- LEFT: Branding (desktop only) --}}
        <div class="hidden lg:flex lg:w-[45%] relative items-center justify-center" style="background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 50%, #40916C 100%);">
            <div class="max-w-md px-12 text-white">
                {{-- Logo --}}
                <div class="flex items-center gap-3 mb-10">
                    <img src="{{ asset('images/agropredict-logo.png') }}" alt="AgroPredict" class="w-12 h-12 object-contain rounded-xl" style="background:rgba(255,255,255,0.1); padding:4px;">
                    <span class="text-xl font-semibold">AgroPredict</span>
                </div>

                <h1 class="text-hero font-semibold leading-tight mb-4">Rekomendasi tanaman berbasis data.</h1>
                <p class="text-body text-white/65 leading-relaxed mb-8">
                    Masukkan kondisi tanah dan iklim lahan Anda, dapatkan rekomendasi tanaman terbaik dari model Machine Learning yang dilatih dari 2.200+ sampel data pertanian.
                </p>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="px-3 py-3 rounded-lg bg-white/10">
                        <p class="text-xl font-semibold">99.7%</p>
                        <p class="text-caption text-white/50">Akurasi RF</p>
                    </div>
                    <div class="px-3 py-3 rounded-lg bg-white/10">
                        <p class="text-xl font-semibold">22</p>
                        <p class="text-caption text-white/50">Jenis tanaman</p>
                    </div>
                    <div class="px-3 py-3 rounded-lg bg-white/10">
                        <p class="text-xl font-semibold">2.2K</p>
                        <p class="text-caption text-white/50">Sampel data</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Form --}}
        <div class="w-full lg:w-[55%] flex flex-col justify-center items-center px-6 sm:px-12 py-10" style="background:#FFFFFF;">
            {{-- Mobile logo --}}
            <div class="lg:hidden mb-8 text-center">
                <div class="flex items-center justify-center gap-2.5 mb-2">
                    <img src="{{ asset('images/agropredict-logo.png') }}" alt="AgroPredict" class="w-10 h-10 object-contain">
                    <span class="text-lg font-medium" style="color:#111827;">AgroPredict</span>
                </div>
                <p class="text-caption" style="color:#9CA3AF;">Sistem Rekomendasi Tanaman</p>
            </div>

            <div class="w-full max-w-sm">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
