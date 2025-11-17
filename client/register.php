<?php
include 'connection.php';

if (isset($_POST['register'])) {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek username sudah ada atau belum
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        $sql = "INSERT INTO users (fullname, username, email, phone, password)
                VALUES ('$fullname', '$username', '$email', '$phone', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - McKingsley Contractor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="register.css" rel="stylesheet">
</head>
<body>


          <header>
    <div class="brand">McKingsley Contractor</div>

    <div class="right-nav">
        <a href="homepage.php" class="nav-btn">Beranda</a>
        <a href="login.php" class="nav-btn">Login</a>
    </div>
</header>


<div class="container mt-5">
    <div class="col-md-5 mx-auto card p-4 shadow">
        <h3 class="text-center mb-3">Create Account</h3>

        <form method="POST">
            <div class="mb-3">
                <label>Fullname</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="mt-3 text-center">
            Already have an account? <a href="login.php">Login</a>
        </p>
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
