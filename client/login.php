<?php
session_start();
include 'connection.php';

$error = "";

// Jika tombol Login ditekan
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // CARI USER BERDASARKAN USERNAME
    $stmt = mysqli_prepare($conn, "SELECT id, fullname, username, password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // JIKA USER ADA
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // VERIFIKASI PASSWORD
        if (password_verify($password, $row['password'])) {

            // SIMPAN KE SESSION
            $_SESSION['id'] = $row['id'];        // PENTING untuk MyProjects
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['username'] = $row['username'];

            header("Location: welcome.php");
            exit;

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Username tidak ditemukan!";
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - McKingsley Contractor</title>
    <link rel="stylesheet" href="login_styling.css">
</head>


<body>


          <header>
    <div class="brand">McKingsley Contractor</div>

    <div class="right-nav">
        <a href="homepage.php" class="nav-btn">Beranda</a>
        <a href="login.php" class="nav-btn">Login</a>
    </div>
</header>

<div class="page-content">
    <div class="login-container">
        <div class="login-box">

                <div class="login-container">
                    <div class="login-box">

                        <h2 class="title">McKingsley Contractor</h2>
                        <p class="subtitle">Silakan login untuk melanjutkan</p>

                        <!-- ERROR MESSAGE -->
                        <?php if ($error != ""): ?>
                        <div class="error"><?= $error ?></div>
                        <?php endif; ?>

                        <!-- FORM LOGIN -->
                        <form method="POST">

                            <label>Username</label>
                            <input type="text" name="username" required>

                            <label>Password</label>
                            <input type="password" name="password" required>

                            <button type="submit" name="login" class="btn-login">Login</button>

                        </form>

                        <p class="register-text">
                            Belum punya akun? <a href="register.php">Buat akun</a>
                        </p>

                    </div>
                </div>

</div>
    </div>
</div>
<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p>&copy; 2025 McKingsley Contractor. Semua hak cipta dilindungi.</p>
  <p>(531)81225545</p><br>
  <p>McKingsley@admin.MKC</p>
</footer>

</body>
</html>
