<x-app-layout>
    <x-slot name="header">
        <h1 class="text-h2 font-medium" style="color:#111827;">History</h1>
    </x-slot>

    <div class="space-y-4">
        @if (session('success'))
            <div class="flex items-center gap-2 px-4 py-3 rounded-card text-body" style="background:#D8F3DC; color:#2D6A4F;" role="status">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="cropcard" style="padding:0;">
            {{-- Search --}}
            <div class="px-5 py-4" style="border-bottom:1px solid #E5E7EB;">
                <form method="GET" action="{{ route('crop.history') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama tanaman..."
                        class="flex-1 px-3.5 py-2 text-body rounded-lg focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'" onblur="this.style.borderColor='#E5E7EB'">
                    <button type="submit" class="px-4 py-2 rounded-lg text-caption font-medium text-white cursor-pointer transition-colors duration-150" style="background:#2D6A4F;" onmouseover="this.style.background='#1B4332'" onmouseout="this.style.background='#2D6A4F'">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('crop.history') }}" class="px-4 py-2 rounded-lg text-caption font-medium cursor-pointer" style="background:#F3F4F6; color:#6B7280;">Reset</a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full" style="border-collapse:separate; border-spacing:0;">
                    <thead>
                        <tr style="background:#F9FAFB;">
                            <th class="px-5 py-3 text-left text-caption font-medium" style="color:#6B7280; border-bottom:1px solid #E5E7EB;">Tanggal</th>
                            <th class="px-5 py-3 text-left text-caption font-medium" style="color:#6B7280; border-bottom:1px solid #E5E7EB;">N, P, K</th>
                            <th class="px-5 py-3 text-left text-caption font-medium hidden md:table-cell" style="color:#6B7280; border-bottom:1px solid #E5E7EB;">Lingkungan</th>
                            <th class="px-5 py-3 text-left text-caption font-medium" style="color:#6B7280; border-bottom:1px solid #E5E7EB;">Rekomendasi</th>
                            <th class="px-5 py-3 text-right text-caption font-medium" style="color:#6B7280; border-bottom:1px solid #E5E7EB;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($predictions as $p)
                            <tr class="transition-colors duration-100" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                                <td class="px-5 py-3.5 text-body whitespace-nowrap" style="color:#6B7280; border-bottom:1px solid #F3F4F6;">{{ $p->created_at->format('d M Y H:i') }}</td>
                                <td class="px-5 py-3.5 text-body font-medium whitespace-nowrap tabular-nums" style="color:#111827; border-bottom:1px solid #F3F4F6;">{{ $p->nitrogen }}, {{ $p->phosphorus }}, {{ $p->potassium }}</td>
                                <td class="px-5 py-3.5 text-body whitespace-nowrap tabular-nums hidden md:table-cell" style="color:#6B7280; border-bottom:1px solid #F3F4F6;">{{ $p->temperature }}°C, {{ $p->humidity }}%, pH {{ $p->ph }}, {{ $p->rainfall }}mm</td>
                                <td class="px-5 py-3.5 whitespace-nowrap" style="border-bottom:1px solid #F3F4F6;">
                                    <span class="px-2 py-0.5 rounded text-caption font-medium capitalize" style="background:#D8F3DC; color:#2D6A4F;">{{ $p->recommended_crop }}</span>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-right" style="border-bottom:1px solid #F3F4F6;">
                                    <a href="{{ route('crop.edit', $p->id) }}" class="text-caption font-medium mr-2 hover:underline" style="color:#40916C;">Edit</a>
                                    <form action="{{ route('crop.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-caption font-medium hover:underline cursor-pointer" style="color:#DC2626;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" style="color:#E5E7EB;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    <p class="text-body" style="color:#9CA3AF;">Tidak ada data riwayat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-5 py-4" style="border-top:1px solid #E5E7EB;">
                {{ $predictions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
