<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

$result = mysqli_query($conn,
    "SELECT * FROM projects WHERE user_id = $user_id ORDER BY id DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Projects</title>
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

<h2>My Projects</h2>

<p class="info-contact">
    Terima kasih telah mengajukan proyek Anda.  
    Tim <strong>McKingsley Contractor</strong> akan menghubungi Anda melalui email atau telepon  
    untuk melakukan <strong>konsultasi online mengenai detail proyek</strong>.
</p>

<a class="btn-add" href="addproject.php">+ Add New Project</a>

<table>
    <tr>
        <th>Project Name</th>
        <th>Project Type</th>
        <th>Project Location</th>
        <th>Project Description</th>
        <th>Project Starting Date</th>
        <th>Status</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['project_title'] ?></td>
        <td><?= $row['project_type'] ?></td>
        <td><?= $row['location'] ?></td>
        <td><?= $row['project_description'] ?></td>
        <td><?= $row['preferred_date'] ?></td>
        <td>
            <?php
            $status = $row['status'];
            $status_class = 'status-pending'; // default
            
            if ($status == 'active') {
                $status_class = 'status-active';
            } elseif ($status == 'completed') {
                $status_class = 'status-completed';
            } elseif ($status == 'cancelled') {
                $status_class = 'status-cancelled';
            } elseif ($status == 'planning') {
                $status_class = 'status-planning';
            }
            ?>
            <span class="status <?= $status_class ?>"><?= ucfirst($status) ?></span>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
  <p>&copy; 2025 McKingsley Contractor. All rights reserved.</p>
  <p>(531)81225545</p><br>
  <p>McKingsley@admin.MKC</p>
</footer>

</body>
</html>