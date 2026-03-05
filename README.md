# Aplikasi Perpustakaan Digital - Panduan Akses

## 📚 Informasi Aplikasi
- **Nama**: Perpustakaan Sekolah Digital
- **Teknologi**: PHP Native (MVC), MySQL, Bootstrap 5
- **Tema**: Maroon Premium

## 🚀 Cara Mengakses Aplikasi

### 1. Pastikan XAMPP Berjalan
- Buka **XAMPP Control Panel**
- Start **Apache** dan **MySQL**

### 2. Import Database
- Buka **phpMyAdmin**: `http://localhost/phpmyadmin`
- Buat database baru atau import file: `db_perpustakaan.sql`
- Database akan otomatis membuat tabel dan akun admin default

### 3. Akses Aplikasi
Buka browser dan akses salah satu URL berikut:

**URL Utama:**
```
http://localhost/fitri/perpustakaan/
```

**URL Alternatif:**
```
http://localhost/fitri/perpustakaan/index.php
http://localhost/fitri/perpustakaan/index.php?page=login
```

**URL Test (untuk verifikasi):**
```
http://localhost/fitri/perpustakaan/test_login.php
http://localhost/fitri/perpustakaan/test_db.php
```

## 🔐 Akun Login Default

### Admin
- **Username**: `admin`
- **Password**: `admin123`

### Siswa (Buat Sendiri)
- Klik "Daftar Sebagai Anggota" di halaman login
- Isi form registrasi
- Login dengan akun yang sudah dibuat

## 📁 Struktur File

```
perpustakaan/
├── config/
│   └── koneksi.php          # Koneksi database
├── controllers/
│   ├── AuthController.php   # Login/Register
│   ├── BukuController.php   # CRUD Buku
│   └── TransaksiController.php # Transaksi
├── models/
│   ├── User.php             # Model User
│   ├── Buku.php             # Model Buku
│   └── Transaksi.php        # Model Transaksi
├── views/
│   ├── auth/                # Login & Register
│   ├── admin/               # Dashboard Admin
│   ├── user/                # Dashboard Siswa
│   └── layouts/             # Header & Footer
├── assets/
│   └── images/              # Gambar
├── index.php                # Entry point
├── db_perpustakaan.sql      # Database SQL
└── .htaccess                # Routing config
```

## ✨ Fitur Aplikasi

### Admin
- ✅ Dashboard dengan statistik real-time
- ✅ CRUD Data Buku (Tambah, Edit, Hapus)
- ✅ CRUD Data Anggota
- ✅ Manajemen Transaksi
- ✅ Laporan Peminjaman (dengan Print)
- ✅ Reset Password User
- ✅ Tabel Aktivitas Terbaru

### Siswa
- ✅ Dashboard dengan statistik pribadi
- ✅ Katalog Buku dengan Pencarian
- ✅ Peminjaman Buku
- ✅ Pengembalian Buku
- ✅ Riwayat Transaksi
- ✅ Section "Buku Terbaru"

## 🎨 Desain
- **Tema**: Maroon Premium (#800000)
- **Layout**: Modern, Responsive
- **Framework**: Bootstrap 5
- **Font**: Inter (Google Fonts)
- **Effects**: Smooth transitions, hover effects
- **Notifications**: SweetAlert2

## 🔧 Troubleshooting

### Halaman Blank/Tidak Muncul
1. Pastikan Apache dan MySQL sudah running
2. Cek error di: `http://localhost/fitri/perpustakaan/test_db.php`
3. Pastikan database sudah diimport
4. Cek file `config/koneksi.php` (username/password database)

### Database Connection Error
- Buka `config/koneksi.php`
- Pastikan:
  - Host: `localhost`
  - User: `root`
  - Password: `` (kosong untuk XAMPP default)
  - Database: `db_perpustakaan`

### Error 404
- Pastikan folder ada di: `C:\xampp\htdocs\fitri\perpustakaan\`
- Cek file `.htaccess` sudah ada
- Restart Apache di XAMPP

## 📞 Informasi Teknis
- **PHP Version**: 8.2.12 (XAMPP)
- **Database**: MySQL via PDO
- **Security**: MD5 Password Hashing, Prepared Statements
- **Session**: PHP Native Sessions

## 🎯 Untuk UKK RPL
Aplikasi ini sudah memenuhi standar UKK RPL:
- ✅ MVC Architecture
- ✅ CRUD Complete
- ✅ Authentication & Authorization
- ✅ Database Normalization
- ✅ Responsive Design
- ✅ Clean Code & Comments
- ✅ Security (SQL Injection Prevention)

---
**Dibuat dengan ❤️ untuk UKK RPL 2025/2026**
