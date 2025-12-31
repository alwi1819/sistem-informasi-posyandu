<?php
// ================= PROTEKSI HALAMAN =================
include '../auth/cek_login.php';

// ================= KONEKSI DATABASE =================
include '../koneksi.php';

// hanya admin boleh edit
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// ================= AMBIL ID =================
if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit;
}

$id = intval($_GET['id']);

// ================= AMBIL DATA BALITA =================
$data = mysqli_query($conn, "SELECT * FROM balita WHERE id_balita = $id");

if (mysqli_num_rows($data) == 0) {
    header("Location: ../index.php");
    exit;
}

$d = mysqli_fetch_assoc($data);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Balita</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-3">Edit Data Balita</h4>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Balita</label>
                    <input type="text" name="nama" class="form-control"
                           value="<?= htmlspecialchars($d['nama_balita']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl" class="form-control"
                           value="<?= $d['tanggal_lahir']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jk" class="form-select" required>
                        <option value="Laki-laki" <?= $d['jenis_kelamin']=='Laki-laki'?'selected':''; ?>>
                            Laki-laki
                        </option>
                        <option value="Perempuan" <?= $d['jenis_kelamin']=='Perempuan'?'selected':''; ?>>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" name="ibu" class="form-control"
                           value="<?= htmlspecialchars($d['nama_ibu']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= 
                        htmlspecialchars($d['alamat']); 
                    ?></textarea>
                </div>

                <button type="submit" name="update" class="btn btn-primary">
                    Update
                </button>
                <a href="../index.php" class="btn btn-secondary">
                    Kembali
                </a>
            </form>

            <hr>
            <h5 class="mt-3">Riwayat Pengukuran</h5>
            <?php
                $id_balita = $id;
                // Periksa apakah tabel pengukuran ada sebelum melakukan query
                $q = false;
                $res_tables = mysqli_query($conn, "SHOW TABLES LIKE 'pengukuran'");
                if ($res_tables && mysqli_num_rows($res_tables) > 0) {
                    $q = mysqli_query($conn, "SELECT * FROM pengukuran WHERE id_balita = $id_balita ORDER BY tanggal DESC");
                }
            ?>
            <table class="table table-sm mt-2">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tinggi (cm)</th>
                        <th>Berat (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($q && mysqli_num_rows($q) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($q)): ?>
                            <tr>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= htmlspecialchars($row['tinggi']); ?></td>
                                <td><?= htmlspecialchars($row['berat']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center">Belum ada pengukuran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// ================= PROSES UPDATE =================
if (isset($_POST['update'])) {

    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $tgl    = $_POST['tgl'];
    $jk     = $_POST['jk'];
    $ibu    = mysqli_real_escape_string($conn, $_POST['ibu']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    mysqli_query($conn, "UPDATE balita SET
        nama_balita     = '$nama',
        tanggal_lahir   = '$tgl',
        jenis_kelamin   = '$jk',
        nama_ibu        = '$ibu',
        alamat          = '$alamat'
        WHERE id_balita = $id
    ");

    header("Location: ../index.php");
    exit;
}
?>
