<?php

namespace App\Http\Controllers;

use App\Models\CropPrediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CropPredictionController extends Controller
{
    /**
     * Tampilkan form rekomendasi tanaman.
     */
    public function index()
    {
        return view('crop.form');
    }

    /**
     * Kirim data ke FastAPI, simpan hasil, dan kembalikan ke form.
     */
    public function predict(Request $request)
    {
        // ── Validasi semua input harus numeric ──
        $validated = $request->validate([
            'nitrogen'    => 'required|numeric',
            'phosphorus'  => 'required|numeric',
            'potassium'   => 'required|numeric',
            'temperature' => 'required|numeric',
            'humidity'    => 'required|numeric',
            'ph'          => 'required|numeric',
            'rainfall'    => 'required|numeric',
        ]);

        try {
            // ── Kirim data ke FastAPI endpoint ──
            $response = Http::timeout(15)->post('http://127.0.0.1:8000/predict', [
                'N'           => (float) $validated['nitrogen'],
                'P'           => (float) $validated['phosphorus'],
                'K'           => (float) $validated['potassium'],
                'temperature' => (float) $validated['temperature'],
                'humidity'    => (float) $validated['humidity'],
                'ph'          => (float) $validated['ph'],
                'rainfall'    => (float) $validated['rainfall'],
            ]);

            if ($response->failed()) {
                return back()->withInput()->withErrors(['api' => 'Gagal menghubungi server AI (Error: ' . $response->status() . '). Pastikan FastAPI berjalan.']);
            }

            // ── Ambil seluruh data dari respons FastAPI ──
            $result = $response->json();

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['api' => 'Tidak dapat terhubung ke API (FastAPI mungkin belum berjalan). Error: ' . $e->getMessage()]);
        }

        // ── Ambil nama tanaman utama (dari RF) ──
        $cropName = $result['prediction_rf'] ?? $result['prediction'] ?? 'Unknown';

        // ── Buat objek model sementara (TIDAK langsung disimpan ke database) ──
        $prediction = new CropPrediction([
            'user_id'          => auth()->id(),
            'nitrogen'         => $validated['nitrogen'],
            'phosphorus'       => $validated['phosphorus'],
            'potassium'        => $validated['potassium'],
            'temperature'      => $validated['temperature'],
            'humidity'         => $validated['humidity'],
            'ph'               => $validated['ph'],
            'rainfall'         => $validated['rainfall'],
            'recommended_crop' => $cropName,
        ]);

        // ── Kembalikan ke form dengan semua hasil prediksi ──
        return back()
            ->with('success', 'Prediksi berhasil!')
            ->with('prediction', $prediction)
            ->with('api_result', $result);
    }

    /**
     * Simpan hasil prediksi ke database secara permanen.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nitrogen'         => 'required|numeric',
            'phosphorus'       => 'required|numeric',
            'potassium'        => 'required|numeric',
            'temperature'      => 'required|numeric',
            'humidity'         => 'required|numeric',
            'ph'               => 'required|numeric',
            'rainfall'         => 'required|numeric',
            'recommended_crop' => 'required|string',
        ]);

        CropPrediction::create([
            'user_id'          => auth()->id(),
            'nitrogen'         => $validated['nitrogen'],
            'phosphorus'       => $validated['phosphorus'],
            'potassium'        => $validated['potassium'],
            'temperature'      => $validated['temperature'],
            'humidity'         => $validated['humidity'],
            'ph'               => $validated['ph'],
            'rainfall'         => $validated['rainfall'],
            'recommended_crop' => $validated['recommended_crop'],
        ]);

        return redirect()->route('crop.history')->with('success', 'Prediksi berhasil disimpan ke riwayat!');
    }

    /**
     * Tampilkan riwayat prediksi.
     */
    public function history(Request $request)
    {
        $query = CropPrediction::where('user_id', auth()->id())->latest();

        // Pencarian berdasarkan nama tanaman
        if ($search = $request->input('search')) {
            $query->where('recommended_crop', 'like', "%{$search}%");
        }

        $predictions = $query->paginate(10);
        return view('crop.history', compact('predictions'));
    }

    /**
     * Tampilkan dashboard statistik.
     */
    public function dashboard()
    {
        $userId = auth()->id();
        
        $totalPredictions = CropPrediction::where('user_id', $userId)->count();
        
        $topCrops = CropPrediction::where('user_id', $userId)
            ->selectRaw('recommended_crop, count(*) as count')
            ->groupBy('recommended_crop')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
            
        $recentPredictions = CropPrediction::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get();

        return view('crop.dashboard', compact('totalPredictions', 'topCrops', 'recentPredictions'));
    }

    /**
     * Tampilkan form edit prediksi.
     */
    public function edit($id)
    {
        $prediction = CropPrediction::where('user_id', auth()->id())->findOrFail($id);
        return view('crop.edit', compact('prediction'));
    }

    /**
     * Update data prediksi.
     */
    public function update(Request $request, $id)
    {
        $prediction = CropPrediction::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'nitrogen'    => 'required|numeric',
            'phosphorus'  => 'required|numeric',
            'potassium'   => 'required|numeric',
            'temperature' => 'required|numeric',
            'humidity'    => 'required|numeric',
            'ph'          => 'required|numeric',
            'rainfall'    => 'required|numeric',
        ]);

        try {
            $response = Http::timeout(15)->post('http://127.0.0.1:8000/predict', [
                'N'           => (float) $validated['nitrogen'],
                'P'           => (float) $validated['phosphorus'],
                'K'           => (float) $validated['potassium'],
                'temperature' => (float) $validated['temperature'],
                'humidity'    => (float) $validated['humidity'],
                'ph'          => (float) $validated['ph'],
                'rainfall'    => (float) $validated['rainfall'],
            ]);

            if ($response->failed()) {
                return back()->withInput()->withErrors(['api' => 'Gagal menghubungi server AI.']);
            }

            $result = $response->json();
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['api' => 'Tidak dapat terhubung ke API. Error: ' . $e->getMessage()]);
        }

        $cropName = $result['prediction_rf'] ?? $result['prediction'] ?? 'Unknown';

        $prediction->update([
            'nitrogen'         => $validated['nitrogen'],
            'phosphorus'       => $validated['phosphorus'],
            'potassium'        => $validated['potassium'],
            'temperature'      => $validated['temperature'],
            'humidity'         => $validated['humidity'],
            'ph'               => $validated['ph'],
            'rainfall'         => $validated['rainfall'],
            'recommended_crop' => $cropName,
        ]);

        return redirect()->route('crop.history')->with('success', 'Prediksi berhasil diperbarui!');
    }

    /**
     * Hapus prediksi.
     */
    public function destroy($id)
    {
        $prediction = CropPrediction::where('user_id', auth()->id())->findOrFail($id);
        $prediction->delete();

        return redirect()->route('crop.history')->with('success', 'Prediksi berhasil dihapus!');
    }
}
