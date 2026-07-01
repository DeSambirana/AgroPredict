<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="AgroPredict — Sistem Rekomendasi Tanaman berbasis Machine Learning">
    <meta name="theme-color" content="#2D6A4F">
    <title>{{ config('app.name', 'AgroPredict') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">

        {{-- ═══ SIDEBAR ═══ --}}
        <aside class="sidebar" :class="{ 'open': sidebarOpen }" @click.away="sidebarOpen = false">
            {{-- Brand --}}
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/agropredict-logo.png') }}" alt="AgroPredict" class="w-8 h-8 object-contain">
                    <span class="text-h2 font-medium" style="color:#111827;">AgroPredict</span>
                </a>
            </div>

            {{-- Nav Items --}}
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('crop.form') }}" class="sidebar-item {{ request()->routeIs('crop.form') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    Prediction
                </a>
                <a href="{{ route('crop.history') }}" class="sidebar-item {{ request()->routeIs('crop.history') || request()->routeIs('crop.edit') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    History
                </a>
            </nav>

            {{-- Footer --}}
            <div class="sidebar-footer">
                <a href="{{ route('profile.edit') }}" class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="sidebar-item" style="color:#DC2626;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/></svg>
                        Logout
                    </a>
                </form>
            </div>
        </aside>

        {{-- ═══ MAIN CONTENT AREA ═══ --}}
        <div class="flex-1 md:ml-[240px] flex flex-col min-h-screen">

            {{-- Top Header --}}
            <header class="top-header">
                {{-- Mobile hamburger --}}
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors cursor-pointer" aria-label="Toggle menu">
                    <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>

                {{-- Page title --}}
                <div class="hidden md:block">
                    @if (isset($header))
                        {{ $header }}
                    @endif
                </div>

                {{-- Right: User --}}
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium text-white" style="background:#2D6A4F;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="hidden sm:block">
                            <p class="text-label text-gray-900 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-caption text-gray-400">Researcher</p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Mobile page title --}}
            @if (isset($header))
                <div class="md:hidden px-4 py-3 border-b" style="border-color:#E5E7EB;">
                    {{ $header }}
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-4 md:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Mobile sidebar overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/30 z-30 md:hidden" x-transition:enter="transition-opacity duration-200" x-transition:leave="transition-opacity duration-200" style="display:none;"></div>

    @stack('scripts')
</body>
</html>
