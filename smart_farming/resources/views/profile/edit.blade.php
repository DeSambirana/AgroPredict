<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-h1 font-semibold" style="color:#111827;">Profil Akun</h1>
            <p class="text-caption text-gray-500 mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
        </div>
    </x-slot>

    <div class="w-full max-w-4xl mx-auto">

        {{-- Profile Avatar Card --}}
        <div class="cropcard mb-6">
            <div class="flex flex-col sm:flex-row items-center gap-5">
                {{-- Avatar --}}
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-2xl font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #2D6A4F 0%, #40916C 100%);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                {{-- Info --}}
                <div class="text-center sm:text-left flex-1">
                    <h2 class="text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-2.5">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" style="background:#D8F3DC; color:#2D6A4F;">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            Akun Aktif
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" style="background:#F3F4F6; color:#6B7280;">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                            Bergabung {{ Auth::user()->created_at->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Informasi Personal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Form Info Profil --}}
                <div class="cropcard">
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Form Password --}}
                <div class="cropcard">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Right: Danger Zone --}}
            <div class="lg:col-span-1">
                <div class="cropcard border border-red-100" style="background: linear-gradient(to bottom, #fff, #FEF2F2);">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
