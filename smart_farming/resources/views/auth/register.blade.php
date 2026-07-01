<x-guest-layout>
    <div class="fade-in">
        <h2 class="text-h1 font-semibold mb-1" style="color:#111827;">Buat akun</h2>
        <p class="text-body mb-6" style="color:#6B7280;">Sudah punya akun? <a href="{{ route('login') }}" class="font-medium hover:underline" style="color:#2D6A4F;">Masuk di sini</a></p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-label mb-1.5" style="color:#111827;">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama Anda"
                    class="w-full px-3.5 py-2.5 text-body rounded-lg transition-colors duration-150 focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div>
                <label for="email" class="block text-label mb-1.5" style="color:#111827;">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com"
                    class="w-full px-3.5 py-2.5 text-body rounded-lg transition-colors duration-150 focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
            <div>
                <label for="password" class="block text-label mb-1.5" style="color:#111827;">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                    class="w-full px-3.5 py-2.5 text-body rounded-lg transition-colors duration-150 focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-label mb-1.5" style="color:#111827;">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password"
                    class="w-full px-3.5 py-2.5 text-body rounded-lg transition-colors duration-150 focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
            <button type="submit" class="w-full py-2.5 rounded-lg text-body font-medium text-white transition-colors duration-150 cursor-pointer" style="background:#2D6A4F;" onmouseover="this.style.background='#1B4332'" onmouseout="this.style.background='#2D6A4F'">
                Daftar Sekarang
            </button>
        </form>
    </div>
</x-guest-layout>
