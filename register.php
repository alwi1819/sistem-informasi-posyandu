<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="col-md-5 mx-auto card p-4 shadow">
        <h4 class="mb-3 text-center">Registrasi Pengguna</h4>
        <form action="proses_register.php" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="contoh@domain.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password2" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Daftar</button>
            <a href="login.php" class="btn btn-link d-block text-center mt-2">Sudah punya akun? Login</a>
        </form>
    </div>
</div>
</body>
</html>
