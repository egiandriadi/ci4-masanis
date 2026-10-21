# Sistem Jurnal Penilaian Perkembangan Siswa TK - Mas Anis

Aplikasi sistem informasi penilaian dan perkembangan harian/tahunan anak berbasis **CodeIgniter 4**, disesuaikan dengan kurikulum serta indikator penilaian karakter anak usia dini (Spiritual, Emosional, Belajar/Kognitif, Adab & Kebiasaan Baik).

---

## 📋 Fitur Utama
- **Autentikasi Multi-Role**: Administrator, Guru (Wali Kelas), dan Orang Tua Murid.
- **Profil Sekolah & Tahun Ajaran**: Pengaturan profil instansi serta semester aktif.
- **Manajemen Indikator Penilaian**: 18 Indikator standar yang terbagi dalam pilar-pilar karakter (Skor 0, 1, dan 2).
- **Penilaian Harian**: Input rekapitulasi penilaian harian per kelas dengan indikator perkembangan siswa.
- **Laporan & Rekap Hasil**: Tinjauan rekap harian, kelas, dan grafik perkembangan tahunan.

---

## 💻 Kebutuhan Sistem (System Requirements)
- **PHP**: Versi `>= 8.1` (Direkomendasikan PHP 8.2)
- **Ekstensi PHP**:
  - `intl`
  - `mbstring`
  - `mysqli`
  - `json`
  - `curl`
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **Composer**: Versi 2.x

---

## 🚀 Panduan Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/egiandriadi/ci4-masanis.git
cd ci4-masanis
```

### 2. Install Dependensi PHP
Jalankan composer untuk mengunduh library yang dibutuhkan:
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi environment:
```bash
cp env .env
```

Buka file `.env` dan sesuaikan konfigurasi aplikasi serta koneksi database:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

# Konfigurasi Database Lokal Anda
database.default.hostname = localhost
database.default.database = db_masanis
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

---

## 🗄️ Setup Database

Tersedia dua opsi untuk inisialisasi database:

### Opsi A: Import Dump SQL (Rekomendasi)
Tersedia file backup lengkap di root folder proyek: `db_masanis.sql`.
1. Buat database baru di MySQL/MariaDB:
   ```sql
   CREATE DATABASE db_masanis;
   ```
2. Import file `db_masanis.sql`:
   - **Melalui Terminal/CLI**:
     ```bash
     mysql -u root -p db_masanis < db_masanis.sql
     ```
   - **Melalui GUI (phpMyAdmin / DBeaver / Navicat)**:
     Pilih database `db_masanis`, lalu gunakan menu **Import** dan pilih file `db_masanis.sql`.

### Opsi B: Menggunakan Fitur Migration & Seeder CI4
Jika ingin membangun struktur dan data bawaan dari kode sumber:
```bash
php spark migrate
php spark db:seed InitialDataSeeder
```

---

## 🏃 Menjalankan Aplikasi

Jalankan built-in development server CodeIgniter:
```bash
php spark serve
```
Buka browser dan akses aplikasi melalui: [http://localhost:8080](http://localhost:8080)

*(Jika menggunakan port lain, sesuaikan juga `app.baseURL` di file `.env`)*

---

## 🔑 Akun Default / Percobaan

| Role | Username / ID | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin` | `admin123` | Akses penuh dashboard, master data, user & sekolah |
| **Guru** | `guru1` | `guru123` | Akses input penilaian dan kelas |
| **Orang Tua** | `2026001` *(NIS)* | `siswa123` | Akses pantau rekap dan perkembangan anak |

---

## 📁 Struktur Folder Utama
- `app/Controllers/`: Logika alur proses aplikasi (Auth, Dashboard, Assessment, dsb).
- `app/Database/Migrations/`: Skema tabel database CodeIgniter.
- `app/Database/Seeds/`: Data awal (indikator, akun demo, pilar karakter).
- `app/Models/`: Model query database.
- `app/Views/`: Template antarmuka pengguna (UI).
- `public/`: Webroot publik (CSS, JS, assets, index.php).
- `db_masanis.sql`: Backup/dump database sistem.
