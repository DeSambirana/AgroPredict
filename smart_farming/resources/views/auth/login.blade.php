<x-guest-layout>
    <div class="fade-in">
        <h2 class="text-h1 font-semibold mb-1" style="color:#111827;">Masuk</h2>
        <p class="text-body mb-6" style="color:#6B7280;">Belum punya akun? <a href="{{ route('register') }}" class="font-medium hover:underline" style="color:#2D6A4F;">Daftar di sini</a></p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-label mb-1.5" style="color:#111827;">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com"
                    class="w-full px-3.5 py-2.5 text-body rounded-lg transition-colors duration-150 focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
            <div>
                <label for="password" class="block text-label mb-1.5" style="color:#111827;">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password"
                    class="w-full px-3.5 py-2.5 text-body rounded-lg transition-colors duration-150 focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded cursor-pointer" style="border-color:#D1D5DB; color:#2D6A4F;">
                    <span class="ml-2 text-body" style="color:#6B7280;">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-caption font-medium" style="color:#2D6A4F;">Lupa password?</a>
                @endif
            </div>
            <button type="submit" class="w-full py-2.5 rounded-lg text-body font-medium text-white transition-colors duration-150 cursor-pointer" style="background:#2D6A4F;" onmouseover="this.style.background='#1B4332'" onmouseout="this.style.background='#2D6A4F'">
                Masuk
            </button>
        </form>
    </div>
</x-guest-layout>
