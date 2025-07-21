<h1 align="center">BSR-Stock - Sistem Manajemen Stok & Permintaan</h1>

<p align="center">
  Aplikasi web internal untuk PT. BSR GLOBAL SURVEY yang dirancang untuk mengelola inventaris (stok alat) dan memproses permintaan pengadaan barang atau dana.
</p>

---

## ✨ Fitur Utama

Aplikasi ini memiliki sistem otentikasi berbasis peran dengan dua level akses: **Super Admin** dan **Admin**.

### Super Admin
Super Admin memiliki kontrol penuh atas semua aspek sistem, termasuk:
- **Dashboard Dinamis:** Menampilkan menu navigasi yang relevan dengan peran Super Admin.
- **Manajemen User:**
  - Membuat, melihat, mengedit, dan menghapus akun pengguna (Admin & Super Admin).
- **Manajemen Alat (Inventaris):**
  - CRUD (Create, Read, Update, Delete) untuk semua data alat di inventaris.
  - Menampilkan status kalibrasi alat dan menandai yang sudah kedaluwarsa.
- **Approval Permintaan:**
  - Melihat semua permintaan yang masuk dari para Admin.
  - Menyetujui (`Approve`) atau menolak (`Reject`) permintaan.
- **Riwayat Transaksi Global:**
  - Melihat riwayat **semua** transaksi pengambilan alat dan permintaan.
  - Fitur pencarian dan filter (berdasarkan nama, tanggal, status) yang interaktif.
  - Fitur pengurutan data (sort by) pada setiap kolom tabel.
- **Ekspor ke Excel:**
  - Mengunduh semua data riwayat ke dalam satu file Excel yang rapi, lengkap dengan border dan header tebal.

### Admin (Pengguna Biasa)
Admin memiliki akses untuk melakukan operasional harian:
- **Dashboard Dinamis:** Menampilkan menu navigasi yang sesuai untuk Admin.
- **Buat Permintaan Baru:**
  - Form dinamis untuk mengajukan permintaan **Barang** (untuk pengadaan item baru) atau **Uang**.
  - Menyertakan deskripsi, jumlah, estimasi harga, dan keterangan.
- **Pengambilan Alat:**
  - Melihat "katalog" alat yang tersedia di inventaris.
  - Mengambil alat dari stok dengan menyertakan jumlah dan keterangan.
- **Aktivitas Saya:**
  - Melihat riwayat transaksi (pengambilan dan permintaan) yang dibuat oleh diri sendiri.
  - Fitur pencarian dan filter untuk riwayat pribadi.
  - Kemampuan untuk **membatalkan** permintaan pribadi yang statusnya masih "waiting".

---

## 💻 Teknologi yang Digunakan

- **Backend:** Laravel 11, PHP 8.2
- **Frontend:** TailwindCSS, Alpine.js, Vite
- **Database:** MySQL
- **Otentikasi:** Laravel Breeze
- **Fitur Tambahan:** Maatwebsite/Excel untuk fungsionalitas ekspor.

---

## 🚀 Panduan Instalasi

Berikut adalah cara untuk menjalankan proyek ini di lingkungan pengembangan lokal.

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/richoap1/bsr-stock.git](https://github.com/richoap1/bsr-stock.git)
    cd bsr-stock
    ```

2.  **Install Dependensi**
    ```bash
    # Install paket PHP
    composer install

    # Install paket JavaScript
    npm install
    ```

3.  **Konfigurasi Environment**
    - Salin file `.env.example` menjadi `.env`.
      ```bash
      cp .env.example .env
      ```
    - Buat database baru di MySQL Anda.
    - Atur konfigurasi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) di dalam file `.env`.
    - Jalankan perintah untuk membuat kunci aplikasi:
      ```bash
      php artisan key:generate
      ```

4.  **Setup Database**
    Jalankan migrasi untuk membuat semua tabel dan seeder untuk mengisi data awal.
    ```bash
    php artisan migrate:fresh --seed
    ```

5.  **Jalankan Server**
    Buka **dua terminal** terpisah:
    - Di terminal 1:
      ```bash
      php artisan serve
      ```
    - Di terminal 2:
      ```bash
      npm run dev
      ```

## © 2025 PT. BSR GLOBAL SURVEY
