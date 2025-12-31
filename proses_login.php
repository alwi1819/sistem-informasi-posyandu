<?php
session_start();
include 'koneksi.php';

// login harus menggunakan email
$email_input = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
$password_input = $_POST['password'] ?? '';

if (!$email_input) {
    echo "Email wajib diisi";
    exit;
}

// pastikan kolom email ada di admin dan users 
$checkAdminEmail = mysqli_query($conn, "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='admin' AND COLUMN_NAME='email'");
if ($checkAdminEmail && mysqli_num_rows($checkAdminEmail) == 0) {
    mysqli_query($conn, "ALTER TABLE admin ADD COLUMN email VARCHAR(100) UNIQUE NULL");
}
$checkUsersEmail = mysqli_query($conn, "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='users' AND COLUMN_NAME='email'");
if ($checkUsersEmail && mysqli_num_rows($checkUsersEmail) == 0) {
    mysqli_query($conn, "ALTER TABLE users ADD COLUMN email VARCHAR(100) UNIQUE NULL");
}

// 1) Cek admin dulu berdasarkan email
$q = mysqli_query($conn, "SELECT * FROM admin WHERE email='".$email_input."' LIMIT 1");
if ($q && mysqli_num_rows($q) > 0) {
    $admin = mysqli_fetch_assoc($q);
    $stored = $admin['password'];

    $ok = false;
    // jika password disimpan menggunakan password_hash
    if (password_verify($password_input, $stored)) {
        $ok = true;
    } else {
        // fallback untuk MD5 lama
        if (md5($password_input) === $stored) {
            $ok = true;
            // upgrade hash ke password_hash agar lebih aman
            $new = password_hash($password_input, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE admin SET password='".mysqli_real_escape_string($conn,$new)."' WHERE id_admin='".intval($admin['id_admin'])."'");
        }
    }

    if ($ok) {
        $_SESSION['login'] = true;
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = $admin['username'];
        $_SESSION['email'] = $admin['email'] ?? $email_input;
        // jika password cocok via MD5 fallback, set flag untuk mengganti password
        if (md5($password_input) === $admin['password']) {
            $_SESSION['must_change_password'] = true;
            header("Location: change_password.php");
            exit;
        }
        header("Location: index.php");
        exit;
    }
}

// 2) Cek users (pendaftaran baru menggunakan password_hash). Cari berdasarkan username lalu verifikasi.
// 2) Cek users berdasarkan email
$q2 = mysqli_query($conn, "SELECT * FROM users WHERE email='".$email_input."' LIMIT 1");
if ($q2 && mysqli_num_rows($q2) > 0) {
    $userRow = mysqli_fetch_assoc($q2);
    $stored = $userRow['password'];

    // Jika password tersimpan menggunakan password_hash
    if (password_verify($password_input, $stored)) {
        // berhasil
        $_SESSION['login'] = true;
        $_SESSION['role'] = 'user';
        $_SESSION['username'] = $userRow['username'];
        $_SESSION['email'] = $userRow['email'];
        header("Location: index.php");
        exit;
    }

    // Jika password sebelumnya disimpan sebagai MD5, terima dan upgrade menjadi password_hash
    if (md5($password_input) === $stored) {
        // upgrade password ke password_hash
        $newHash = password_hash($password_input, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='".mysqli_real_escape_string($conn,$newHash)."' WHERE id='".intval($userRow['id'])."'");

        $_SESSION['login'] = true;
        $_SESSION['role'] = 'user';
        $_SESSION['username'] = $userRow['username'];
        $_SESSION['email'] = $userRow['email'] ?? $email_input;
        // arahkan ke halaman ganti password sekali
        $_SESSION['must_change_password'] = true;
        header("Location: change_password.php");
        exit;
    }
}

echo "Login gagal";
