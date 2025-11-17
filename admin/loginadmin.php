<?php
session_start();
include 'connect.php';

$error = "";

// Jika tombol Login ditekan
if (isset($_POST['login'])) {
    $username = strtolower(trim($_POST['username']));  // Trim dan lowercase untuk case-insensitive
    $password = trim($_POST['password']);  // Trim untuk menghilangkan spasi

    // CARI USER BERDASARKAN USERNAME (case-insensitive)
    $stmt = mysqli_prepare($conn, "SELECT id, username, fullname, password FROM admin_users WHERE LOWER(username) = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // JIKA USER ADA
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // VERIFIKASI PASSWORD
        $is_password_correct = false;
        if (password_verify($password, $row['password'])) {
            // Password sudah di-hash dan cocok
            $is_password_correct = true;
        } elseif ($password === $row['password']) {
            // Password plain text (belum di-hash), cocokkan langsung
            $is_password_correct = true;
            // Otomatis hash ulang dan update DB untuk keamanan selanjutnya
            $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_stmt = mysqli_prepare($conn, "UPDATE admin_users SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($update_stmt, "si", $new_hashed_password, $row['id']);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
            // Catatan: Ini membuat password di-DB sekarang hashed
        }

        if ($is_password_correct) {
            // SIMPAN KE SESSION
            $_SESSION['id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['username'] = $row['username'];

            header("Location: projects.php");
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
    <link rel="stylesheet" href="loginadmin.css">
</head>
<body>
<div class="page-content">
    <div class="login-container">
        <div class="login-box">
            <h2 class="title">McKingsley Contractor Admin</h2>
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
        </div>
    </div>
</div>
</body>
</html>