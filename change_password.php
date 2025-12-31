<?php
include 'auth/cek_login.php';
include 'koneksi.php';

if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? 'user';

if (!isset($_SESSION['must_change_password'])) {
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p1 = $_POST['password'] ?? '';
    $p2 = $_POST['password2'] ?? '';

    if (!$p1 || !$p2) {
        $errors[] = 'Isi semua kolom.';
    } elseif ($p1 !== $p2) {
        $errors[] = 'Password dan konfirmasi tidak sama.';
    } elseif (strlen($p1) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }

    if (empty($errors)) {
        $hash = password_hash($p1, PASSWORD_DEFAULT);
        if ($role === 'admin') {
            mysqli_query($conn, "UPDATE admin SET password='".mysqli_real_escape_string($conn,$hash)."' WHERE username='".mysqli_real_escape_string($conn,$username)."'");
        } else {
            mysqli_query($conn, "UPDATE users SET password='".mysqli_real_escape_string($conn,$hash)."' WHERE username='".mysqli_real_escape_string($conn,$username)."'");
        }

        // hapus flag sesi
        unset($_SESSION['must_change_password']);

        // redirect ke index
        header('Location: index.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="col-md-6 mx-auto card p-4 shadow">
        <h4 class="mb-3">Ganti Password</h4>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $e): ?>
                    <div><?= htmlspecialchars($e); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password2" class="form-control" required>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
