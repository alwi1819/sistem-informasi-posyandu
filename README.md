# Sistem Informasi Data Balita Posyandu

## Nama Anggota Kelompok
- Mukhammad khoirul aminin 2413030033
- Nanda firstyanto putra 2413030046
- Nandana febry pradana2413030117
- Muhammad Elfanda 2413030076
- Muhammad Alwi Anwarudin 2413030066


## Deskripsi Sistem
Sistem Informasi Data Balita Posyandu merupakan aplikasi berbasis web yang
digunakan untuk mengelola data balita dan data pengukuran kesehatan
(tinggi dan berat badan). Sistem ini menerapkan konsep CRUD serta
menyediakan RESTful API yang dapat dimanfaatkan oleh pihak lain.

## Fitur Sistem
- Login Admin dan User
- CRUD Data Balita
- CRUD Data Pengukuran Balita
- RESTful API Data Balita
- Manajemen Hak Akses

## Teknologi yang Digunakan
- PHP Native
- MySQL
- HTML, CSS, Bootstrap
- RESTful API (JSON)

## Struktur Database
- Tabel balita
- Tabel pengukuran
- Tabel user
- Tabel admin

## Dokumentasi RESTful API

### Endpoint: Data Balita
URL:
GET /api/balita.php

Method:
GET

Response:
{
  "status": true,
  "data": [
    {
      "id_balita": "10",
      "nama_balita": "Rafi",
      "tanggal_lahir": "2023-06-12",
      "jenis_kelamin": "Laki-laki",
      "nama_ibu": "Ani",
      "alamat": "Ds. Suka Maju RT 01 RW 02"
    }
  ]
}

## Cara Menjalankan Aplikasi
1. Clone repository dari GitHub
2. Letakkan folder project di direktori htdocs
3. Import database MySQL (.sql)
4. Jalankan Apache dan MySQL (XAMPP)
5. Akses melalui browser
