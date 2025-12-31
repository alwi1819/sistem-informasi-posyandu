<?php
include 'koneksi.php';

// ambil input
$username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
$email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
$pass = $_POST['password'] ?? '';
$pass2 = $_POST['password2'] ?? '';

if (!$email) {
    echo "Email wajib diisi";
    exit;
}

if (!$username || !$pass) {
    echo "Isi semua kolom";
    exit;
}

if ($pass !== $pass2) {
    echo "Password tidak sama";
    exit;
}

// Pastikan tabel admin memiliki kolom email 
$resAdminCols = mysqli_query($conn, "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='admin' AND COLUMN_NAME='email'");
if ($resAdminCols && mysqli_num_rows($resAdminCols) == 0) {
    mysqli_query($conn, "ALTER TABLE admin ADD COLUMN email VARCHAR(100) UNIQUE NULL");
}

// cek username dan email
$q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if ($q && mysqli_num_rows($q) > 0) {
    echo "Username sudah terpakai";
    exit;
}
$qe = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
if ($qe && mysqli_num_rows($qe) > 0) {
    echo "Email sudah terpakai";
    exit;
}

// Hash password menggunakan password_hash
// Hash password menggunakan password_hash
$hash = password_hash($pass, PASSWORD_DEFAULT);
// masukkan email 
mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hash')");

header('Location: login.php');
exit;
