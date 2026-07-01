<x-app-layout>
    <x-slot name="header">
        <h1 class="text-h2 font-medium" style="color:#111827;">Crop Prediction</h1>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 items-start">

        {{-- ════════════════════════════════════
             LEFT COLUMN — Form Input (40%)
        ═════════════════════════════════════ --}}
        <section class="lg:col-span-2 space-y-4">

            {{-- Form Header --}}
            <div class="cropcard">
                <div class="flex items-center gap-3 mb-1">
                    <svg class="w-5 h-5" style="color:#2D6A4F;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                    <h2 class="text-h2 font-medium" style="color:#111827;">Masukkan kondisi lahan</h2>
                </div>
                <p class="text-caption" style="color:#9CA3AF;">Atur setiap parameter dengan slider atau ketik angka langsung.</p>
            </div>

            @error('api')
                <div class="flex items-start gap-2.5 px-4 py-3 rounded-card text-body" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" role="alert">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                    <div><p class="font-medium text-label">Terjadi masalah</p><p class="text-caption mt-0.5">{{ $message }}</p></div>
                </div>
            @enderror

            <form id="predictionForm" method="POST" action="{{ route('crop.predict') }}" class="space-y-3">
                @csrf

                {{-- 7 Parameter Sliders --}}
                <x-param-slider label="N (Nitrogen)" name="nitrogen" unit="kg/ha" :min="0" :max="140" :step="1" :default="50" optimal="70 – 90" />
                <x-param-slider label="P (Phosphorus)" name="phosphorus" unit="kg/ha" :min="5" :max="145" :step="1" :default="50" optimal="40 – 65" />
                <x-param-slider label="K (Potassium)" name="potassium" unit="kg/ha" :min="5" :max="205" :step="1" :default="50" optimal="30 – 60" />
                <x-param-slider label="Temperature" name="temperature" unit="°C" :min="8" :max="44" :step="0.1" :default="25.0" optimal="22 – 28" />
                <x-param-slider label="Humidity" name="humidity" unit="%" :min="14" :max="100" :step="0.1" :default="70.0" optimal="60 – 80" />
                <x-param-slider label="pH" name="ph" unit="pH" :min="3.5" :max="10" :step="0.1" :default="6.5" optimal="5.5 – 7.5" />
                <x-param-slider label="Rainfall" name="rainfall" unit="mm" :min="20" :max="300" :step="1" :default="120" optimal="100 – 200" />

                {{-- Submit --}}
                <button type="submit" id="submitBtn" class="w-full py-3 rounded-lg text-body font-medium text-white transition-colors duration-150 cursor-pointer flex items-center justify-center gap-2" style="background:#2D6A4F;" onmouseover="this.style.background='#1B4332'" onmouseout="this.style.background='#2D6A4F'">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    Prediksi Tanaman
                </button>

                {{-- Reset --}}
                <button type="reset" id="resetBtn" class="w-full py-2.5 rounded-lg text-body font-medium transition-colors duration-150 cursor-pointer" style="background:transparent; border:1px solid #E5E7EB; color:#6B7280;" onmouseover="this.style.borderColor='#D1D5DB'; this.style.color='#111827'" onmouseout="this.style.borderColor='#E5E7EB'; this.style.color='#6B7280'">
                    Reset ke nilai default
                </button>
            </form>

            {{-- Model note --}}
            <p class="text-caption text-center" style="color:#9CA3AF;">Model menggunakan Random Forest (akurasi 99.77%)</p>
        </section>

        {{-- ════════════════════════════════════
             RIGHT COLUMN — Results (60%)
        ═════════════════════════════════════ --}}
        <section class="lg:col-span-3 space-y-4">
            @php
                $prediction = session('prediction');
                $apiResult = session('api_result');

                // Crop emoji/image mapping
                $cropImages = [
                    'rice' => '🌾', 'wheat' => '🌾', 'maize' => '🌽', 'corn' => '🌽',
                    'chickpea' => '🫘', 'kidneybeans' => '🫘', 'pigeonpeas' => '🫘',
                    'mothbeans' => '🫘', 'mungbean' => '🫘', 'blackgram' => '🫘', 'lentil' => '🫘',
                    'pomegranate' => '🍎', 'banana' => '🍌', 'mango' => '🥭',
                    'grapes' => '🍇', 'watermelon' => '🍉', 'muskmelon' => '🍈',
                    'apple' => '🍎', 'orange' => '🍊', 'papaya' => '🍈',
                    'coconut' => '🥥', 'cotton' => '🧵', 'jute' => '🌿',
                    'coffee' => '☕',
                ];
            @endphp

            @if($prediction && $apiResult)
                {{-- ✅ HAS RESULTS --}}
                <div class="space-y-4 fade-in">

                    {{-- Card: Rekomendasi Tanaman with Image --}}
                    <div class="cropcard" style="border-left: 4px solid #2D6A4F;">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4" style="color:#40916C;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189"/></svg>
                            <h2 class="text-h2 font-medium" style="color:#111827;">Rekomendasi Tanaman</h2>
                        </div>

                        @php $cropName = $apiResult['prediction_rf'] ?? $prediction->recommended_crop; @endphp

                        <div class="flex items-center gap-4 mb-4">
                            {{-- Crop Image/Emoji --}}
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl shadow-sm" style="background: linear-gradient(135deg, #D8F3DC, #B7E4C7);">
                                {{ $cropImages[strtolower($cropName)] ?? '🌱' }}
                            </div>
                            <div>
                                <p class="text-caption font-medium" style="color:#9CA3AF;">Tanaman yang cocok</p>
                                <p class="text-hero font-semibold capitalize" style="color:#2D6A4F;">{{ $cropName }}</p>
                            </div>
                        </div>

                        {{-- Confidence --}}
                        @if(isset($apiResult['confidence_rf']))
                            <div class="mb-3">
                                <div class="flex justify-between mb-1">
                                    <span class="text-caption" style="color:#6B7280;">Confidence (Random Forest)</span>
                                    <span class="text-label font-medium" style="color:#2D6A4F;">{{ number_format($apiResult['confidence_rf'] * 100, 1) }}%</span>
                                </div>
                                <div class="confidence-bar-track">
                                    <div class="confidence-bar-fill" style="width:{{ $apiResult['confidence_rf'] * 100 }}%"></div>
                                </div>
                            </div>
                        @endif
                        @if(isset($apiResult['confidence_mlp']))
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-caption" style="color:#6B7280;">Confidence (MLP Neural Network)</span>
                                    <span class="text-label font-medium" style="color:#40916C;">{{ number_format($apiResult['confidence_mlp'] * 100, 1) }}%</span>
                                </div>
                                <div class="confidence-bar-track">
                                    <div class="confidence-bar-fill" style="width:{{ $apiResult['confidence_mlp'] * 100 }}%"></div>
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-2 mt-5 items-stretch">
                            <a href="{{ route('crop.history') }}" class="flex-1 text-center py-2.5 rounded-lg text-caption font-medium cursor-pointer transition-colors duration-150" style="background:#D8F3DC; color:#2D6A4F; text-decoration:none;" onmouseover="this.style.background='#B7E4C7'" onmouseout="this.style.background='#D8F3DC'">Lihat Riwayat</a>
                            
                            <form action="{{ route('crop.store') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="nitrogen" value="{{ $prediction->nitrogen }}">
                                <input type="hidden" name="phosphorus" value="{{ $prediction->phosphorus }}">
                                <input type="hidden" name="potassium" value="{{ $prediction->potassium }}">
                                <input type="hidden" name="temperature" value="{{ $prediction->temperature }}">
                                <input type="hidden" name="humidity" value="{{ $prediction->humidity }}">
                                <input type="hidden" name="ph" value="{{ $prediction->ph }}">
                                <input type="hidden" name="rainfall" value="{{ $prediction->rainfall }}">
                                <input type="hidden" name="recommended_crop" value="{{ $prediction->recommended_crop }}">
                                
                                <button type="submit" class="w-full h-full text-center py-2.5 rounded-lg text-caption font-medium cursor-pointer transition-colors duration-150" style="border:1px solid #E5E7EB; color:#6B7280; background:transparent;" onmouseover="this.style.borderColor='#D1D5DB'; this.style.background='#F9FAFB';" onmouseout="this.style.borderColor='#E5E7EB'; this.style.background='transparent';">
                                    Simpan hasil
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Card: Zona Agroklimat --}}
                    @if(isset($apiResult['zona_agroklimat']))
                        <div class="cropcard">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4" style="color:#40916C;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                <h2 class="text-h2 font-medium" style="color:#111827;">Zona Agroklimat</h2>
                            </div>
                            @php
                                $zonaDesc = [
                                    1 => 'Zona tropis lembap — cocok untuk padi, tebu, kelapa',
                                    2 => 'Zona subtropis kering — cocok untuk gandum, jagung, kedelai',
                                    3 => 'Zona dataran tinggi — cocok untuk kentang, kopi, teh',
                                    4 => 'Zona semi-arid — cocok untuk jawawut, sorgum, kacang tanah',
                                ];
                                $zona = $apiResult['zona_agroklimat'];
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-body font-semibold text-white" style="background:#40916C;">{{ $zona }}</div>
                                <p class="text-body" style="color:#6B7280;">{{ $zonaDesc[$zona] ?? "Klaster zona $zona (K-Means)" }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Card: Faktor Paling Berpengaruh (Horizontal Bar) --}}
                    <div class="cropcard">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4" style="color:#40916C;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                            <h2 class="text-h2 font-medium" style="color:#111827;">Faktor Paling Berpengaruh</h2>
                        </div>
                        @php
                            $maxes = ['nitrogen'=>140,'phosphorus'=>145,'potassium'=>205,'temperature'=>44,'humidity'=>100,'ph'=>10,'rainfall'=>300];
                            $labels = ['nitrogen'=>'Nitrogen','phosphorus'=>'Phosphorus','potassium'=>'Potassium','temperature'=>'Temperature','humidity'=>'Humidity','ph'=>'pH','rainfall'=>'Rainfall'];
                            $factors = [];
                            foreach($maxes as $k=>$m) {
                                $factors[$k] = round(($prediction->$k / $m) * 100, 1);
                            }
                            arsort($factors);
                        @endphp
                        @foreach($factors as $key => $pct)
                            <div class="h-bar">
                                <span class="h-bar-label">{{ $labels[$key] }}</span>
                                <div class="h-bar-track"><div class="h-bar-fill" style="width:{{ min($pct,100) }}%"></div></div>
                                <span class="h-bar-value">{{ $prediction->$key }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Card: Top 3 Rekomendasi with Crop Images --}}
                    @if(isset($apiResult['top3_crops']) && count($apiResult['top3_crops']) > 0)
                        <div class="cropcard">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-4 h-4" style="color:#40916C;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3"/></svg>
                                <h2 class="text-h2 font-medium" style="color:#111827;">Top 3 Rekomendasi</h2>
                            </div>
                            @foreach($apiResult['top3_crops'] as $i => $crop)
                                <div class="flex items-center gap-3 py-2.5 {{ $i > 0 ? 'border-t' : '' }}" style="border-color:#F3F4F6;">
                                    {{-- Crop emoji --}}
                                    <span class="w-9 h-9 rounded-xl flex items-center justify-center text-lg {{ $i===0 ? 'shadow-sm' : '' }}" style="background:{{ $i===0 ? 'linear-gradient(135deg, #D8F3DC, #B7E4C7)' : ($i===1 ? '#F0FDF4' : '#F9FAFB') }};">
                                        {{ $cropImages[strtolower($crop['crop'])] ?? '🌱' }}
                                    </span>
                                    <span class="flex-1 text-body font-medium capitalize" style="color:#111827;">{{ $crop['crop'] }}</span>
                                    <div class="text-right">
                                        <span class="text-caption font-semibold tabular-nums" style="color:{{ $i===0 ? '#2D6A4F' : '#6B7280' }};">{{ number_format($crop['probability'],1) }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Card: Profil Kondisi (Radar Chart) --}}
                    <div class="cropcard">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4" style="color:#40916C;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"/></svg>
                            <h2 class="text-h2 font-medium" style="color:#111827;">Profil Kondisi Anda</h2>
                        </div>
                        <div class="flex justify-center">
                            <canvas id="radarChart" width="320" height="280"></canvas>
                        </div>
                    </div>
                </div>

            @else
                {{-- 🔲 EMPTY STATE — Info & List Tanaman --}}
                <div class="space-y-5 fade-in">
                    {{-- Welcome/Call to Action Card --}}
                    <div class="cropcard text-center py-8 px-6 bg-gradient-to-br from-white to-green-50/20 border border-green-100">
                        <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-green-100">
                            <svg class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Ayo Prediksi Tanaman Lahan Anda!</h2>
                        <p class="text-gray-600 text-sm max-w-sm mx-auto leading-relaxed">
                            Atur parameter tanah dan iklim di sebelah kiri (Nitrogen, Fosfor, Kalium, Suhu, Kelembaban, pH, Curah Hujan), kemudian klik tombol <strong>Prediksi Tanaman</strong>.
                        </p>
                    </div>

                    {{-- List Tanaman yang Didukung --}}
                    <div class="cropcard">
                        <h3 class="text-h2 font-medium mb-4 flex items-center gap-2" style="color:#111827;">
                            <svg class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 0-8.25 3m8.25-3v1.386m-8.25-4.893 8.25 3M1.5 17.25h1.5M1.5 13.5h1.5M1.5 9.75h1.5M15 8.25v.008H15V8.25Z" />
                            </svg>
                            Tanaman yang Dapat Diprediksi
                        </h3>
                        <p class="text-caption text-gray-500 mb-4">Sistem cerdas AgroPredict mendukung analisis kesesuaian untuk berbagai komoditas pertanian berikut:</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @php
                                $supportedCrops = [
                                    ['Padi', '🌾', 'Cocok di tropis basah'],
                                    ['Jagung', '🌽', 'Kebutuhan air sedang'],
                                    ['Kopi', '☕', 'Dataran tinggi/sejuk'],
                                    ['Kelapa', '🥥', 'Pesisir & tropis hangat'],
                                    ['Mangga', '🥭', 'Suhu hangat musiman'],
                                    ['Pisang', '🍌', 'Tanah subur lembap'],
                                    ['Semangka', '🍉', 'Drainase tanah baik'],
                                    ['Melon', '🍈', 'Paparan cahaya penuh'],
                                    ['Apel', '🍎', 'Suhu dingin sejuk'],
                                    ['Jeruk', '🍊', 'Kelembaban moderat'],
                                    ['Kapas', '🧵', 'Daerah kering hangat'],
                                    ['Pepaya', '🍈', 'Tanah gembur subur'],
                                ];
                            @endphp
                            @foreach($supportedCrops as $c)
                                <div class="flex items-center gap-2.5 p-2 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50/10 transition-colors">
                                    <span class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center text-lg shrink-0">
                                        {{ $c[1] }}
                                    </span>
                                    <div>
                                        <p class="text-caption font-semibold text-gray-800 capitalize">{{ $c[0] }}</p>
                                        <p class="text-[10px] text-gray-400 font-medium leading-none mt-0.5">{{ $c[2] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>

    @push('scripts')
    {{-- Chart.js for Radar --}}
    @if(session('prediction') && session('api_result'))
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('radarChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Nitrogen','Phosphorus','Potassium','Temperature','Humidity','pH','Rainfall'],
                    datasets: [
                        {
                            label: 'Kondisi Anda',
                            data: [
                                {{ $prediction->nitrogen / 140 * 100 }},
                                {{ $prediction->phosphorus / 145 * 100 }},
                                {{ $prediction->potassium / 205 * 100 }},
                                {{ $prediction->temperature / 44 * 100 }},
                                {{ $prediction->humidity / 100 * 100 }},
                                {{ $prediction->ph / 10 * 100 }},
                                {{ $prediction->rainfall / 300 * 100 }},
                            ],
                            backgroundColor: 'rgba(45,106,79,0.12)',
                            borderColor: '#2D6A4F',
                            borderWidth: 2,
                            pointBackgroundColor: '#2D6A4F',
                            pointRadius: 3,
                        },
                        {
                            label: 'Rata-rata Optimal',
                            data: [57, 38, 29, 59, 72, 65, 50],
                            backgroundColor: 'rgba(82,183,136,0.08)',
                            borderColor: '#95D5B2',
                            borderWidth: 1.5,
                            borderDash: [4,3],
                            pointBackgroundColor: '#95D5B2',
                            pointRadius: 2,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 100,
                            ticks: { display: false },
                            grid: { color: '#F3F4F6' },
                            angleLines: { color: '#F3F4F6' },
                            pointLabels: { font: { family: 'Inter', size: 11, weight: '500' }, color: '#6B7280' },
                        },
                    },
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Inter', size: 11 }, color: '#6B7280', padding: 16, usePointStyle: true, pointStyle: 'circle' } },
                    },
                },
            });
        }
    </script>
    @endif

    {{-- Loading state on submit --}}
    <script>
        document.getElementById('predictionForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'wait';
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Menganalisis kondisi lahan...';
        });
    </script>
    @endpush
</x-app-layout>
