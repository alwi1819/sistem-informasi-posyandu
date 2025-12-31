<?php
include '../auth/cek_login.php';
include '../koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// ambil daftar balita untuk select
$balita_res = mysqli_query($conn, "SELECT id_balita, nama_balita FROM balita ORDER BY nama_balita");

if (isset($_POST['simpan'])) {
    $id_balita = intval($_POST['id_balita']);
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
    $tinggi = isset($_POST['tinggi']) && $_POST['tinggi'] !== '' ? floatval($_POST['tinggi']) : 'NULL';
    $berat = isset($_POST['berat']) && $_POST['berat'] !== '' ? floatval($_POST['berat']) : 'NULL';

    mysqli_query($conn, "INSERT INTO pengukuran (id_balita, tanggal, tinggi, berat) VALUES (
        $id_balita, '$tanggal', $tinggi, $berat
    )");

    header('Location: ../index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengukuran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h4>Tambah Pengukuran</h4>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Balita</label>
                    <select name="id_balita" class="form-select" required>
                        <option value="">-- Pilih Balita --</option>
                        <?php while($b = mysqli_fetch_assoc($balita_res)): ?>
                            <option value="<?= $b['id_balita']; ?>"><?= htmlspecialchars($b['nama_balita']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tinggi (cm)</label>
                    <input type="number" step="0.1" name="tinggi" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" step="0.1" name="berat" class="form-control">
                </div>
                <button class="btn btn-success" name="simpan">Simpan</button>
                <a href="../index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
