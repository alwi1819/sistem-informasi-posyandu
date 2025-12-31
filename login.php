<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark d-flex align-items-center" style="min-height:100vh;">

<div class="container">
    <div class="col-md-4 mx-auto card p-4 shadow">

        <!-- LOGO -->
        <div class="text-center mb-3">
            <img src="style/logo-puskesmas.png"
                 alt="Logo Puskesmas"
                 width="80">
        </div>

        <h4 class="text-center mb-3">Login Posyandu</h4>

        <form action="proses_login.php" method="post">
            <input type="email"
                   name="email"
                   class="form-control mb-2"
                   placeholder="Email"
                   required>

            <input type="password"
                   name="password"
                   class="form-control mb-3"
                   placeholder="Password"
                   required>

            <button class="btn btn-success w-100">
                Login
            </button>
        </form>

        <div class="text-center mt-2">
            <a href="register.php" class="text-decoration-none">Daftar sebagai pengguna</a>
        </div>

    </div>
</div>

</body>
</html>
