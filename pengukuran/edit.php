<?php
include '../auth/cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: ../index.php');
    exit;
}

// ambil pengukuran
$q = mysqli_query($conn, "SELECT p.*, b.nama_balita FROM pengukuran p JOIN balita b ON p.id_balita = b.id_balita WHERE p.id = $id");
if (!$q || mysqli_num_rows($q) == 0) {
    header('Location: ../index.php');
    exit;
}
$row = mysqli_fetch_assoc($q);

if (isset($_POST['update'])) {
    $tanggal = $_POST['tanggal'] ?? $row['tanggal'];
    $tinggi = isset($_POST['tinggi']) && $_POST['tinggi'] !== '' ? floatval($_POST['tinggi']) : 'NULL';
    $berat = isset($_POST['berat']) && $_POST['berat'] !== '' ? floatval($_POST['berat']) : 'NULL';

    mysqli_query($conn, "UPDATE pengukuran SET tanggal = '$tanggal', tinggi = $tinggi, berat = $berat WHERE id = $id");
    header('Location: ../index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengukuran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h4>Edit Pengukuran - <?= htmlspecialchars($row['nama_balita']); ?></h4>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($row['tanggal']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tinggi (cm)</label>
                    <input type="number" step="0.1" name="tinggi" class="form-control" value="<?= htmlspecialchars($row['tinggi']); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" step="0.1" name="berat" class="form-control" value="<?= htmlspecialchars($row['berat']); ?>">
                </div>
                <button class="btn btn-primary" name="update">Update</button>
                <a href="../index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
