<?php
include '../auth/cek_login.php';
include '../koneksi.php';

// hanya admin boleh hapus
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Cek apakah parameter id ada
if (isset($_GET['id'])) {

    $id = intval($_GET['id']); // amankan id

    // Hapus data
    mysqli_query($conn, "DELETE FROM balita WHERE id_balita = $id");

}

// Kembali ke halaman index
header("Location: ../index.php");
exit;
?>
