<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
  <img src="https://fastapi.tiangolo.com/img/logo-margin/logo-teal.png" width="200" alt="FastAPI Logo">
  <br><br>
  
  <h1>🌱 AgroPredict </h1>
  <p><b>Sistem Pendukung Keputusan Rekomendasi Tanaman Berbasis Machine Learning & Agroklimat</b></p>
  
  <p>
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
    <img src="https://img.shields.io/badge/FastAPI-009688?style=for-the-badge&logo=FastAPI&logoColor=white" alt="FastAPI">
    <img src="https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white" alt="Python">
    <img src="https://img.shields.io/badge/scikit_learn-F7931E?style=for-the-badge&logo=scikit-learn&logoColor=white" alt="Scikit-Learn">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  </p>
</div>

---

## 📖 Deskripsi Proyek
**SmartFarm AI** adalah aplikasi web berbasis *microservices* yang dirancang untuk membantu sektor pertanian cerdas (*Smart Farming*). Aplikasi ini mampu merekomendasikan jenis komoditas tanaman terbaik yang harus ditanam berdasarkan 7 parameter tanah dan iklim (Nitrogen, Fosfor, Kalium, Suhu, Kelembaban, pH, dan Curah Hujan).

Proyek ini mendemonstrasikan integrasi antara sistem **Web Framework (PHP/Laravel)** sebagai Antarmuka Pengguna dan **REST API (Python/FastAPI)** sebagai mesin inferensi *Machine Learning*.

## ✨ Fitur Utama
- **🔐 Autentikasi Keamanan:** Sistem Login, Register, dan Logout menggunakan *Laravel Breeze*.
- **🧠 Prediksi AI Cerdas:** Menggunakan 3 algoritma sekaligus (*Random Forest*, *Multi-Layer Perceptron*, dan *K-Means* Clustering).
- **📊 Dasbor Interaktif:** Ringkasan jumlah prediksi dan Top 5 Tanaman yang paling sering direkomendasikan.
- **📝 Manajemen Riwayat (CRUD):** Semua data prediksi tersimpan di database dan pengguna dapat melakukan operasi Tampil (Read), Ubah/Prediksi Ulang (Update), dan Hapus (Delete).
- **🎨 UI/UX Modern:** Antarmuka responsif mengusung desain *Glassmorphism* dengan Tailwind CSS.

---

## 🏗️ Arsitektur Sistem (Microservices)

Sistem ini terbagi menjadi 2 server yang berjalan secara independen:

1. **Service Machine Learning (Port 8000)** ➔ Menggunakan `FastAPI` + `Uvicorn` untuk me-load file model `crop_model.joblib` (akurasi RF 99.55%).
2. **Service Web App (Port 8080)** ➔ Menggunakan `Laravel 11` untuk menangani sesi, database riwayat, dan menampilkan UI ke pengguna.

---

## 🚀 Cara Instalasi & Menjalankan Aplikasi

Pastikan komputer Anda sudah terinstal **PHP**, **Composer**, **Node.js**, dan **Python (3.8+)**.

### Langkah 1: Kloning Repositori
```bash
git clone https://github.com/USERNAME_ANDA/smartfarm-ai.git
cd smartfarm-ai
```

### Langkah 2: Jalankan Server FastAPI (Terminal 1)
Buka terminal baru dan arahkan ke folder `fastapi`:
```bash
cd fastapi
# Install library yang dibutuhkan (opsional: gunakan virtual environment)
pip install fastapi uvicorn pandas scikit-learn joblib numpy pydantic

# Jalankan server
python main.py
```
*Pastikan terminal ini menampilkan pesan `Uvicorn running on http://0.0.0.0:8000` dan jangan ditutup.*

### Langkah 3: Jalankan Server Laravel (Terminal 2)
Buka terminal baru lagi dan arahkan ke folder `smart_farming`:
```bash
cd smart_farming

# Install dependensi PHP dan Javascript
composer install
npm install
npm run build

# Copy .env dan generate key
cp .env.example .env
php artisan key:generate

# Migrasi Database (Pastikan config DB di .env sudah sesuai: MySQL/PostgreSQL/SQLite)
php artisan migrate

# Jalankan server web
php artisan serve --port=8080
```

### Langkah 4: Akses Aplikasi
Buka browser dan kunjungi: **`http://127.0.0.1:8080`**

---

## 📄 Lisensi
[MIT License](LICENSE) - Bebas digunakan dan dimodifikasi untuk tujuan pembelajaran.
