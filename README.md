
```markdown
# 🏥 Sistem Informasi Posyandu - Data Balita

## 👥 Anggota Kelompok
| No | Nama | NIM |
|----|------|-----|
| 1 | Mukhammad Khoirul Aminin | 2413030033 |
| 2 | Nanda Firstyanto Putra | 2413030046 |
| 3 | Nandana Febry Pradana | 2413030117 |
| 4 | Muhammad Elfanda | 2413030076 |
| 5 | Muhammad Alwi Anwarudin | 2413030066 |

## 📖 Deskripsi Proyek
Sistem Informasi Posyandu merupakan aplikasi berbasis web untuk mengelola data balita dan pertumbuhannya di posyandu. Sistem ini dilengkapi dengan **CRUD lengkap** dan **RESTful API** yang dapat digunakan oleh pihak ketiga untuk integrasi sistem.

## ✨ Fitur Utama
### 🔐 Autentikasi & Keamanan
- Login/Register untuk Admin dan User
- Manajemen hak akses (Admin/User)
- Change password
- Session management

### 📊 Manajemen Data (CRUD)
- **Data Balita**: Tambah, edit, hapus, lihat detail
- **Data Pengukuran**: Rekam tinggi/berat badan balita
- **Riwayat Pertumbuhan**: Pantau perkembangan balita

### 🔗 RESTful API
- Endpoint untuk akses data balita
- Format response JSON
- Support metode HTTP: GET, POST, PUT, DELETE

## 🛠️ Teknologi yang Digunakan
| Komponen | Teknologi |
|----------|-----------|
| Backend | PHP Native |
| Database | MySQL |
| Frontend | HTML5, CSS3, Bootstrap 5 |
| API | RESTful (JSON) |
| Server | Apache (XAMPP) |

## 🗄️ Struktur Database
### Tabel-tabel utama:
1. **balita**
   - `id_balita` (INT, Primary Key)
   - `nama_balita` (VARCHAR)
   - `tanggal_lahir` (DATE)
   - `jenis_kelamin` (ENUM)
   - `nama_ibu` (VARCHAR)
   - `alamat` (TEXT)
   - `created_at` (TIMESTAMP)

2. **pengukuran**
   - `id_pengukuran` (INT)
   - `id_balita` (INT, Foreign Key)
   - `tinggi_badan` (DECIMAL)
   - `berat_badan` (DECIMAL)
   - `tanggal_ukur` (DATE)
   - `catatan` (TEXT)

3. **users**
   - `id_user` (INT)
   - `username` (VARCHAR)
   - `password` (VARCHAR)
   - `level` (ENUM: 'admin', 'user')
   - `email` (VARCHAR)

## 🚀 Instalasi & Konfigurasi

### Prasyarat
- XAMPP (PHP 7.4+, MySQL 5.7+)
- Web browser modern

### Langkah Instalasi
1. **Download atau Clone Proyek**
   - Download ZIP dari GitHub atau clone repository

2. **Pindahkan ke Folder Server**
   - Ekstrak folder `posyandu` ke `C:\xampp\htdocs\` (Windows) atau `/var/www/html/` (Linux)

3. **Setup Database**
   - Buka phpMyAdmin (`http://localhost/phpmyadmin`)
   - Buat database baru: `posyandu_db`
   - Import file SQL dari folder database atau buat tabel manual:

   ```sql
   CREATE DATABASE posyandu_db;
   USE posyandu_db;
   
   CREATE TABLE balita (
       id_balita INT AUTO_INCREMENT PRIMARY KEY,
       nama_balita VARCHAR(100) NOT NULL,
       tanggal_lahir DATE NOT NULL,
       jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
       nama_ibu VARCHAR(100) NOT NULL,
       alamat TEXT NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   
   CREATE TABLE users (
       id_user INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL,
       level ENUM('admin', 'user') DEFAULT 'user',
       email VARCHAR(100)
   );
   ```

4. **User Default untuk Testing**
   ```sql
   INSERT INTO users (username, password, level, email) 
   VALUES 
   ('admin', MD5('admin123'), 'admin', 'admin@posyandu.com'),
   ('user', MD5('user123'), 'user', 'user@posyandu.com');
   ```

5. **Konfigurasi Koneksi Database**
   - Buka file `koneksi.php`
   - Sesuaikan dengan setting database Anda:

   ```php
   <?php
   $host = "localhost";
   $user = "root";      // username MySQL
   $pass = "";          // password MySQL
   $db   = "posyandu_db";
   
   $conn = mysqli_connect($host, $user, $pass, $db);
   ?>
   ```

6. **Jalankan Aplikasi**
   - Start Apache dan MySQL di XAMPP Control Panel
   - Buka browser, akses: `http://localhost/posyandu/`
   - Login dengan:
     - **Admin**: username `admin`, password `admin123`
     - **User**: username `user`, password `user123`

## 📡 RESTful API Documentation

### Base URL
```
http://localhost/posyandu/api/balita.php
```

### Endpoint: Data Balita

#### 1. GET Semua Data Balita
```http
GET http://localhost/posyandu/api/balita.php
```

**Response Sukses:**
```json
{
  "status": true,
  "data": [
    {
      "id_balita": "10",
      "nama_balita": "Rafi",
      "tanggal_lahir": "2023-06-12",
      "jenis_kelamin": "Laki-laki",
      "nama_ibu": "Ani",
      "alamat": "Ds. Suka Maju RT 01 RW 02",
      "created_at": "2024-01-10 14:30:00"
    }
  ]
}
```

#### 2. GET Data Balita by ID
```http
GET http://localhost/posyandu/api/balita.php?id={id}
```

**Contoh:**
```http
GET http://localhost/posyandu/api/balita.php?id=10
```

**Response:**
```json
{
  "status": true,
  "data": {
    "id_balita": "10",
    "nama_balita": "Rafi",
    "tanggal_lahir": "2023-06-12",
    "jenis_kelamin": "Laki-laki",
    "nama_ibu": "Ani",
    "alamat": "Ds. Suka Maju RT 01 RW 02"
  }
}
```

### Contoh Penggunaan API dengan cURL

#### Get semua data balita:
```bash
curl -X GET "http://localhost/posyandu/api/balita.php"
```

#### Get data balita by ID:
```bash
curl -X GET "http://localhost/posyandu/api/balita.php?id=10"
```

## 📁 Struktur Folder Proyek (Aktual)
```
posyandu/
├── api/
│   ├── balita.php
│   ├── auth/
│   │   ├── cek_login.php
│   │   └── ... 
│   └── ... (endpoint lainnya)
├── admin/
│   ├── balita/
│   │   ├── detail.php
│   │   ├── edit.php
│   │   ├── hapus.php
│   │   └── tambah.php
│   └── pergukuran/
│       ├── edit.php
│       ├── hapus.php
│       └── tambah.php
├── assets/
│   ├── css/
│   │   ├── img.css
│   │   └── style-dark.css
│   ├── img/
│   │   └── logo-puskesmas.png
│   └── BOOTSTRAP/
├── includes/ (koneksi, auth check, dll)
├── index.php
├── login.php
├── register.php
├── logout.php
├── change_password.php
├── proses_login.php
├── proses_register.php
├── koneksi.php
├── README.md
└── poster.pdf
```
## 🔧 Panduan Penggunaan

### Untuk Admin:
1. Login dengan akun admin (`admin/admin123`)
2. Akses menu Data Balita untuk CRUD
3. Kelola data pengukuran di menu Pengukuran
4. Gunakan fitur ganti password jika perlu

### Untuk User/Umum:
1. Register akun baru di halaman register
2. Login dengan akun yang telah dibuat
3. Akses data yang tersedia sesuai hak akses

### Menggunakan API:
1. API dapat diakses tanpa autentikasi untuk membaca data
2. Gunakan endpoint: `http://localhost/posyandu/api/balita.php`
3. Tambahkan parameter `?id={id}` untuk data spesifik
4. Response dalam format JSON

## 🔍 Troubleshooting

### Masalah Umum:
1. **Halaman tidak muncul**
   - Pastikan XAMPP Apache dan MySQL running
   - Cek folder berada di `htdocs/posyandu/`

2. **Koneksi database gagal**
   - Periksa file `koneksi.php`
   - Verifikasi username/password MySQL

3. **API tidak merespon**
   - Pastikan file `api/balita.php` ada
   - Cek koneksi database di file API

4. **Login tidak berhasil**
   - Pastikan tabel users ada dan berisi data
   - Cek proses hashing password (MD5)

### Cara Testing:
1. **Testing Web:**
   - Akses `http://localhost/posyandu/`
   - Login dengan user default
   - Test semua fitur CRUD

2. **Testing API:**
   ```bash
   # Test endpoint
   curl http://localhost/posyandu/api/balita.php
   
   # Test dengan browser
   http://localhost/posyandu/api/balita.php?id=1
   ```

## 📝 Catatan Penting
1. **Untuk keamanan produksi:**
   - Ganti password default
   - Tambahkan validasi input
   - Implementasi CSRF protection

2. **Pengembangan API lebih lanjut:**
   - Tambahkan endpoint POST/PUT/DELETE
   - Implementasi API key/token
   - Dokumentasi lengkap dengan Swagger

3. **Fitur yang bisa dikembangkan:**
   - Export data ke Excel/PDF
   - Grafik pertumbuhan balita
   - Notifikasi imunisasi
   - Mobile app version

## 📄 Informasi Proyek
- **Mata Kuliah**: Pemrograman Web
- **Tujuan**: Tugas Akhir Kelompok
- **Tahun**: 2026
- **Kampus**: Universitas Nusantara PGRI Kediri

## 🙏 Credits
- Kelompok 5 - Pemrograman Web

---
**Status**: ✅ Selesai  
**Version**: 1.0  
**Last Update**: 4-01-2026

© 2024 Kelompok 5 - Sistem Informasi Posyandu
```