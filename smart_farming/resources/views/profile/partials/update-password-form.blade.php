<section>
    <header class="mb-6">
        <h2 class="text-h3 font-semibold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
            {{ __('Ubah Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password Saat Ini') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-20" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password Baru') }}</label>
            <input id="update_password_password" name="password" type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-20" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Konfirmasi Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-20" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150 gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                {{ __('Perbarui Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-green-600 flex items-center gap-1.5 bg-green-50 px-3 py-1.5 rounded-full"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ __('Password diubah.') }}
                </p>
            @endif
        </div>
    </form>
</section>
