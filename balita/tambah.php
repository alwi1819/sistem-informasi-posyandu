<?php
// ================= PROTEKSI HALAMAN =================
include '../auth/cek_login.php';

// ================= KONEKSI DATABASE =================
include '../koneksi.php';

// hanya admin yang boleh tambah
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Balita</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-3">Tambah Data Balita</h4>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Balita</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jk" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" name="ibu" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan
                </button>
                <a href="../index.php" class="btn btn-secondary">
                    Kembali
                </a>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// ================= PROSES SIMPAN DATA =================
if (isset($_POST['simpan'])) {

    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $tgl    = $_POST['tgl'];
    $jk     = $_POST['jk'];
    $ibu    = mysqli_real_escape_string($conn, $_POST['ibu']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    mysqli_query($conn, "INSERT INTO balita (
        nama_balita, tanggal_lahir, jenis_kelamin, nama_ibu, alamat
    ) VALUES (
        '$nama', '$tgl', '$jk', '$ibu', '$alamat'
    )");

    header("Location: ../index.php");
    exit;
}
?>
