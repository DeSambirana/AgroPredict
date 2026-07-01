<x-app-layout>
    <x-slot name="header">
        <h1 class="text-h2 font-medium" style="color:#111827;">Edit Prediksi</h1>
    </x-slot>

    <div class="max-w-3xl space-y-4">
        @if ($errors->any())
            <div class="flex items-start gap-2.5 px-4 py-3 rounded-card text-body" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" role="alert">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                <div><p class="font-medium text-label">Terdapat kesalahan:</p>
                    <ul class="list-disc pl-5 mt-1 space-y-0.5 text-caption">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="cropcard">
            <div class="flex items-center gap-2 mb-5">
                <svg class="w-4 h-4" style="color:#40916C;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                <h2 class="text-h2 font-medium" style="color:#111827;">Ubah parameter dan prediksi ulang</h2>
            </div>

            <form action="{{ route('crop.update', $prediction->id) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nutrisi Tanah --}}
                    <div class="space-y-4">
                        <p class="text-caption font-medium uppercase tracking-wider" style="color:#9CA3AF;">Nutrisi Tanah</p>
                        @foreach([
                            ['nitrogen', 'Nitrogen (N)', 'kg/ha', 0, 140, 1],
                            ['phosphorus', 'Phosphorus (P)', 'kg/ha', 5, 145, 1],
                            ['potassium', 'Potassium (K)', 'kg/ha', 5, 205, 1],
                        ] as [$name, $label, $unit, $min, $max, $step])
                            <div>
                                <label for="{{ $name }}" class="flex justify-between text-label mb-1.5" style="color:#111827;">
                                    <span>{{ $label }}</span>
                                    <span class="text-caption" style="color:#9CA3AF;">{{ $unit }}</span>
                                </label>
                                <input type="number" id="{{ $name }}" name="{{ $name }}" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}" value="{{ old($name, $prediction->$name) }}" required
                                    class="w-full px-3.5 py-2.5 text-body rounded-lg focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                                @error($name)<p class="text-caption mt-1" style="color:#DC2626;">{{ $message }}</p>@enderror
                            </div>
                        @endforeach
                    </div>

                    {{-- Kondisi Iklim --}}
                    <div class="space-y-4">
                        <p class="text-caption font-medium uppercase tracking-wider" style="color:#9CA3AF;">Kondisi Iklim</p>
                        @foreach([
                            ['temperature', 'Temperature', '°C', 8, 44, 0.1],
                            ['humidity', 'Humidity', '%', 14, 100, 0.1],
                            ['ph', 'pH', 'pH', 3.5, 10, 0.1],
                            ['rainfall', 'Rainfall', 'mm', 20, 300, 1],
                        ] as [$name, $label, $unit, $min, $max, $step])
                            <div>
                                <label for="{{ $name }}" class="flex justify-between text-label mb-1.5" style="color:#111827;">
                                    <span>{{ $label }}</span>
                                    <span class="text-caption" style="color:#9CA3AF;">{{ $unit }}</span>
                                </label>
                                <input type="number" id="{{ $name }}" name="{{ $name }}" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}" value="{{ old($name, $prediction->$name) }}" required
                                    class="w-full px-3.5 py-2.5 text-body rounded-lg focus:outline-none" style="background:#F9FAFB; border:1px solid #E5E7EB; color:#111827;" onfocus="this.style.borderColor='#40916C'; this.style.boxShadow='0 0 0 2px rgba(64,145,108,0.12)'" onblur="this.style.borderColor='#E5E7EB'; this.style.boxShadow='none'">
                                @error($name)<p class="text-caption mt-1" style="color:#DC2626;">{{ $message }}</p>@enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4" style="border-top:1px solid #E5E7EB;">
                    <a href="{{ route('crop.history') }}" class="px-4 py-2.5 rounded-lg text-body font-medium cursor-pointer" style="color:#6B7280;">Batal</a>
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-body font-medium text-white cursor-pointer transition-colors duration-150" style="background:#2D6A4F;" onmouseover="this.style.background='#1B4332'" onmouseout="this.style.background='#2D6A4F'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182"/></svg>
                        Update & Prediksi Ulang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
