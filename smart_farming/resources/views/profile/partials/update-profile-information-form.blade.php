<section>
    <header class="mb-6">
        <h2 class="text-h3 font-semibold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui nama dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Nama Lengkap') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none h-full">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <input id="name" name="name" type="text" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-20" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2 text-sm text-red-600" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Alamat Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none h-full">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <input id="email" name="email" type="email" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-20" :value="old('email', $user->email)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2 text-sm text-red-600" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                    <p class="text-sm text-yellow-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ __('Alamat email Anda belum diverifikasi.') }}
                        <button form="send-verification" class="ml-auto underline text-yellow-700 hover:text-yellow-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 font-medium">
                            {{ __('Kirim ulang') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-green-600 flex items-center gap-1.5 bg-green-50 px-3 py-1.5 rounded-full"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ __('Berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
