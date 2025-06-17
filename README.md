# Kasir Laravel - Sistem Manajemen Penjualan

Sistem manajemen penjualan berbasis web yang dibangun dengan Laravel untuk membantu pengelolaan transaksi, barang, pelanggan, dan laporan penjualan.

## Fitur Utama

- **Manajemen Barang**: Tambah, edit, hapus, dan lihat stok barang
- **Manajemen Pelanggan**: Kelola data pelanggan
- **Transaksi Penjualan**: Proses penjualan dengan keranjang belanja
- **Invoice Otomatis**: Generate invoice untuk setiap transaksi
- **Laporan Penjualan**: Filter berdasarkan tanggal dan cetak laporan
- **Manajemen User**: Sistem role admin dan karyawan
- **Autentikasi**: Login/logout dengan validasi

## Teknologi

- PHP 8.0+
- Laravel 9.x
- MySQL
- Bootstrap 5
- jQuery

## Instalasi

1. Clone repository:
```bash
git clone https://github.com/Ian7672/kasir-laravel-v1.git
cd kasir-laravel-v1
```

2. Salin file environment:
```bash
cp .env.example .env
```

3. Install dependencies:
```bash
composer install
```

4. Generate key aplikasi:
```bash
php artisan key:generate
```

5. Buat database dan sesuaikan konfigurasi di `.env`:
```env
DB_DATABASE=nama_database
DB_USERNAME=username_db
DB_PASSWORD=password_db
```

6. Jalankan migrasi:
```bash
php artisan migrate
```

7. Jalankan server development:
```bash
php artisan serve
```

Buka http://localhost:8000 di browser Anda.

## Penggunaan

### Login
- **Admin**: 
  - Token: 0KASIRADMIN9##

### Fitur Admin
- Mengelola semua data (barang, pelanggan, transaksi)
- Menambah/mengedit/hapus user
- Akses penuh ke semua laporan

### Fitur Karyawan
- Melihat daftar barang dan pelanggan
- Membuat transaksi penjualan
- Mencetak invoice
- Melihat laporan penjualan (terbatas)

## Desain Antarmuka

Sistem ini menggunakan desain modern dengan:
- Tema gelap dengan aksen hijau
- Sidebar responsif
- Tabel dengan fitur pencarian
- Form yang user-friendly
- Notifikasi interaktif

## Kontribusi

Pull request dipersilakan. Untuk perubahan besar, buka issue terlebih dahulu untuk mendiskusikan apa yang ingin Anda ubah.

## Demo Aplikasi

[Link Demo Aplikasi]()


## 👨‍💻 Developer

Dikembangkan oleh **Ian7672** - [GitHub Profile](https://github.com/Ian7672)

---

© 2025 kasir-laravel-v1. All rights reserved.
