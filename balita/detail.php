<?php
// Halaman detail balita dan riwayat pengukuran (lihatable oleh semua user yang login)
include '../auth/cek_login.php';
include '../koneksi.php';

if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = intval($_GET['id']);

$q = mysqli_query($conn, "SELECT * FROM balita WHERE id_balita = $id");
if (!$q || mysqli_num_rows($q) == 0) {
    header('Location: ../index.php');
    exit;
}

$balita = mysqli_fetch_assoc($q);

// ambil pengukuran untuk balita ini
$res = mysqli_query($conn, "SELECT * FROM pengukuran WHERE id_balita = $id ORDER BY tanggal DESC");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail <?= htmlspecialchars($balita['nama_balita']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Detail Balita: <?= htmlspecialchars($balita['nama_balita']); ?></h4>
                <div>
                    <a href="../index.php" class="btn btn-secondary btn-sm">Kembali</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="edit.php?id=<?= $id; ?>" class="btn btn-warning btn-sm">Edit Data</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <strong>Tanggal Lahir:</strong> <?= htmlspecialchars($balita['tanggal_lahir']); ?><br>
                <strong>Jenis Kelamin:</strong> <?= htmlspecialchars($balita['jenis_kelamin']); ?><br>
                <strong>Nama Ibu:</strong> <?= htmlspecialchars($balita['nama_ibu']); ?><br>
                <strong>Alamat:</strong> <?= nl2br(htmlspecialchars($balita['alamat'])); ?>
            </div>

            <h5>Riwayat Pengukuran</h5>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tinggi (cm)</th>
                        <th>Berat (kg)</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res && mysqli_num_rows($res) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($res)): ?>
                            <tr>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= htmlspecialchars($row['tinggi']); ?></td>
                                <td><?= htmlspecialchars($row['berat']); ?></td>
                                <td>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <a href="../pengukuran/edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="../pengukuran/hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                    <?php else: ?>
                                        <span class="text-muted">Hanya lihat</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">Belum ada pengukuran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
