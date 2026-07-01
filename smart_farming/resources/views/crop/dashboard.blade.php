<x-app-layout>
    <x-slot name="header">
        <h1 class="text-h2 font-medium" style="color:#111827;">Dashboard</h1>
    </x-slot>

    <div class="space-y-5">
        
        {{-- Welcome Banner --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-800 to-green-600 text-white p-6 md:p-8 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="relative z-10 max-w-xl">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">Sistem Cerdas AgroPredict</span>
                <h2 class="text-2xl md:text-3xl font-bold mt-3 mb-2">Selamat Datang di AgroPredict, {{ Auth::user()->name }}!</h2>
                <p class="text-green-100 text-sm md:text-base leading-relaxed mb-5">
                    Optimalkan hasil pertanian Anda dengan menganalisis nutrisi tanah secara cerdas. Dapatkan rekomendasi tanaman yang presisi berdasarkan data riil lahan Anda.
                </p>
                <a href="{{ route('crop.form') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-emerald-900 font-semibold rounded-lg text-sm hover:bg-green-50 transition-colors shadow-sm cursor-pointer" style="text-decoration:none;">
                    Mulai Prediksi
                    <svg class="w-4 h-4 text-emerald-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
            {{-- Agricultural Image illustration --}}
            <div class="w-full md:w-1/3 max-w-[260px] aspect-[4/3] rounded-xl overflow-hidden shadow-md border-2 border-white/20 shrink-0">
                <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=600&auto=format&fit=crop" alt="Smart Agriculture" class="w-full h-full object-cover">
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="cropcard">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#D8F3DC;">
                        <svg class="w-5 h-5" style="color:#2D6A4F;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                    </div>
                    <div>
                        <p class="text-caption" style="color:#9CA3AF;">Total Prediksi</p>
                        <p class="text-h1 font-semibold tabular-nums" style="color:#111827;">{{ $totalPredictions }}</p>
                    </div>
                </div>
            </div>
            <div class="cropcard">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#D8F3DC;">
                        <svg class="w-5 h-5" style="color:#2D6A4F;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189"/></svg>
                    </div>
                    <div>
                        <p class="text-caption" style="color:#9CA3AF;">Jenis Tanaman</p>
                        <p class="text-h1 font-semibold tabular-nums" style="color:#111827;">{{ $topCrops->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="cropcard">
                <a href="{{ route('crop.form') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:#D8F3DC;">
                        <svg class="w-5 h-5" style="color:#2D6A4F;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </div>
                    <div>
                        <p class="text-caption" style="color:#9CA3AF;">Aksi Cepat</p>
                        <p class="text-body font-medium group-hover:underline" style="color:#2D6A4F;">Prediksi baru →</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Top 5 Tanaman --}}
            <div class="cropcard">
                <h2 class="text-h2 font-medium mb-4" style="color:#111827;">Top 5 Tanaman</h2>
                @if($topCrops->isEmpty())
                    <div class="text-center py-8">
                        <svg class="w-8 h-8 mx-auto mb-2" style="color:#E5E7EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189"/></svg>
                        <p class="text-body" style="color:#9CA3AF;">Belum ada data.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($topCrops as $crop)
                            <div>
                                <div class="flex justify-between text-caption mb-1">
                                    <span class="font-medium capitalize" style="color:#111827;">{{ $crop->recommended_crop }}</span>
                                    <span class="tabular-nums" style="color:#9CA3AF;">{{ $crop->count }}×</span>
                                </div>
                                <div class="w-full h-2 rounded-full" style="background:#F3F4F6;">
                                    <div class="h-2 rounded-full transition-all duration-400" style="background:#52B788; width:{{ $totalPredictions > 0 ? ($crop->count / $totalPredictions) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Prediksi Terbaru --}}
            <div class="cropcard">
                <h2 class="text-h2 font-medium mb-4" style="color:#111827;">5 Prediksi Terbaru</h2>
                @if($recentPredictions->isEmpty())
                    <div class="text-center py-8">
                        <svg class="w-8 h-8 mx-auto mb-2" style="color:#E5E7EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        <p class="text-body" style="color:#9CA3AF;">Belum ada data.</p>
                    </div>
                @else
                    <div class="divide-y" style="border-color:#F3F4F6;">
                        @foreach($recentPredictions as $p)
                            <div class="flex items-center justify-between py-2.5">
                                <div>
                                    <p class="text-body font-medium capitalize" style="color:#111827;">{{ $p->recommended_crop }}</p>
                                    <p class="text-caption" style="color:#9CA3AF;">{{ $p->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-0.5 rounded text-caption font-medium" style="background:#D8F3DC; color:#2D6A4F;">
                                    N:{{ $p->nitrogen }} P:{{ $p->phosphorus }} K:{{ $p->potassium }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
