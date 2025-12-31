<?php
// ================= PROTEKSI HALAMAN =================
include 'auth/cek_login.php';

// ================= KONEKSI DATABASE =================
include 'koneksi.php';

// ================= AMBIL DATA DARI API =================
$api_url = "http://localhost/posyandu/api/balita.php";
$response = file_get_contents($api_url);
$result = json_decode($response, true);

$data_balita = $result['data'] ?? [];

// peran saat ini
$role = $_SESSION['role'] ?? 'user';

// ================= DATA GRAFIK JENIS KELAMIN =================
$jk = [];
foreach ($data_balita as $b) {
    $jk[$b['jenis_kelamin']] = ($jk[$b['jenis_kelamin']] ?? 0) + 1;
}

$label_jk = array_keys($jk);
$data_jk = array_values($jk);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Posyandu</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light text-dark">
    <div class="container mt-4">
        <div class="card bg-white shadow">
            <div class="card-body">

                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <!-- KIRI: LOGO + JUDUL -->
                    <div class="d-flex align-items-center gap-3">
                        <img src="style/logo-puskesmas.png" alt="Logo Puskesmas" width="50">

                        <div>
                            <h4 class="mb-1">Data Balita Posyandu</h4>
                            <span class="badge bg-success">
                                Total Balita: <?= count($data_balita); ?>
                            </span>
                        </div>
                    </div>

                    <!-- KANAN: Profil + Logout -->
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($_SESSION['username'] ?? ($_SESSION['email'] ?? 'Pengguna')); ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                            <li class="px-3 py-2">
                                <strong><?= htmlspecialchars($_SESSION['username'] ?? '-'); ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($_SESSION['email'] ?? '-'); ?></small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="px-3"><a href="change_password.php" class="btn btn-sm btn-outline-primary w-100">Ganti Password</a></li>
                            <li class="px-3 mt-2"><a href="logout.php" class="btn btn-danger btn-sm w-100">Logout</a></li>
                        </ul>
                    </div>
                </div>


                <!-- TOMBOL TAMBAH -->
                <?php if ($role === 'admin'): ?>
                    <a href="balita/tambah.php" class="btn btn-success mb-3">+ Tambah Data</a>
                <?php endif; ?>

                <!-- TABEL -->
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Nama Balita</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Nama Ibu</th>
                            <th>Alamat</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data_balita): ?>
                            <?php foreach ($data_balita as $d): ?>
                                <tr>
                                    <td><?= htmlspecialchars($d['nama_balita']); ?></td>
                                    <td><?= htmlspecialchars($d['jenis_kelamin']); ?></td>
                                    <td>
                                        <?= date('d-m-Y', strtotime($d['tanggal_lahir'])); ?>
                                    </td>
                                    <td><?= htmlspecialchars($d['nama_ibu']); ?></td>
                                    <td><?= htmlspecialchars($d['alamat']); ?></td>
                                    <td>
                                        <a href="balita/detail.php?id=<?= $d['id_balita']; ?>" class="btn btn-info btn-sm">Lihat</a>
                                        <?php if ($role === 'admin'): ?>
                                            <a href="balita/edit.php?id=<?= $d['id_balita']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="balita/hapus.php?id=<?= $d['id_balita']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Data belum tersedia</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- BAGIAN PENGUKURAN -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Data Pengukuran</h5>
                        <?php if ($role === 'admin'): ?>
                                <a href="pengukuran/tambah.php" class="btn btn-success btn-sm">+ Tambah Pengukuran</a>
                            <?php endif; ?>
                    </div>
                    <?php
                        // ambil data pengukuran bergabung dengan balita
                        $res = mysqli_query($conn, "SELECT p.*, b.nama_balita FROM pengukuran p JOIN balita b ON p.id_balita = b.id_balita ORDER BY p.tanggal DESC");
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Balita</th>
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
                                        <td><?= htmlspecialchars($row['nama_balita']); ?></td>
                                        <td><?= htmlspecialchars($row['tinggi']); ?></td>
                                        <td><?= htmlspecialchars($row['berat']); ?></td>
                                        <td>
                                            <?php if ($role === 'admin'): ?>
                                                <a href="pengukuran/edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="pengukuran/hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center">Belum ada data pengukuran</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>


                <!-- GRAFIK -->
                <div class="row mt-4">
                    <div class="col-md-6 mx-auto">
                        <div class="card border">
                            <div class="card-body">
                                <h6 class="text-center">Grafik Jenis Kelamin Balita</h6>
                                <canvas id="grafikJK"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LINK API -->
                <div class="text-center mt-4">
                    <small class="text-muted">
                        Sumber Data API :
                        <a href="api/balita.php" target="_blank" class="text-decoration-none">
                            api/balita.php
                        </a>
                    </small>
                </div>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        new Chart(document.getElementById('grafikJK'), {
            type: 'pie',
            data: {
                labels: <?= json_encode($label_jk); ?>,
                datasets: [{
                    data: <?= json_encode($data_jk); ?>,
                    backgroundColor: ['#0d6efd', '#dc3545']
                }]
            }
        });
    </script>

</body>

</html>