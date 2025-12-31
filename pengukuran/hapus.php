<?php
include '../auth/cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM pengukuran WHERE id = $id");
}
header('Location: ../index.php');
exit;
?>
