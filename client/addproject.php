<?php
session_start();
include 'connection.php';

$success = "";
$error = "";

if (isset($_POST['submit'])) {

    $user_id     = $_SESSION['id'];
    $title       = $_POST['project_title'];
    $type        = $_POST['project_type'];
    $location    = $_POST['location'];
    $description = $_POST['project_description'];
    $date        = $_POST['preferred_date'];

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO projects (
            user_id, project_title, project_type, location, project_description, preferred_date
         ) VALUES (?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "isssss",
        $user_id, $title, $type, $location, $description, $date
    );

    if (mysqli_stmt_execute($stmt)) {

        // Redirect ke My Projects
        header("Location: myprojects.php?added=success");
        exit;

    } else {
        $error = "Gagal menambahkan project!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>
    <link rel="stylesheet" href="projects.css">
</head>
<body>

<!-- NAVBAR -->
<header>
    <div class="brand">McKingsley Contractor</div>

    <div class="right-nav">
         <span class="username">
    Hi, <?= $_SESSION['fullname']; ?> (<?= $_SESSION['username']; ?>) !
</span>

        <a href="myprojects.php">
            <button class="nav-btn btn-projects">My Projects</button>
        </a>

        <a href="welcome.php">
            <button class="nav-btn btn-home">Home</button>
        </a>

        <a href="logout.php">
            <button class="nav-btn btn-logout">Logout</button>
        </a>
    </div>
</header>

<h2>Tambah Project Baru</h2>

<form method="POST">

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <label>Project Title</label>
    <input type="text" name="project_title" required>

    <label>Project Type</label>
    <select name="project_type" required>
        <option value="">-- pilih jenis proyek --</option>
        <option value="Architectural Planning">Architectural Planning</option>
        <option value="Residential Construction">Residential Construction</option>
        <option value="Commercial Construction">Commercial Construction</option>
        <option value="Skyscraper Construction">Skyscraper Construction</option>
        <option value="Renovation">Renovation</option>
    </select>

    <label>Project Location</label>
    <input type="text" name="location" required>

    <label>Project Description</label>
    <textarea name="project_description" required></textarea>

    <label>Starting Date</label>
    <input type="date" name="preferred_date" required>

    <button type="submit" name="submit">Add Project</button>
</form>

<p style="text-align:center;">
    <a href="myprojects.php">Kembali ke My Projects</a>
</p>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
  <p>&copy; 2025 McKingsley Contractor. All rights reserved.</p>
  <br>
  <p>(531)81225545</p><br>
  <p>McKingsley@admin.MKC</p>
</footer>

</body>
</html>
