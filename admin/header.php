<?php
// Cek session
if (!isset($_SESSION['id'])) {
    header("Location: loginadmin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - McKingsley Contractor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <strong>McKingsley Contractor</strong>
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text text-light me-3">
                    Hello, <?php echo $_SESSION['username'] ?? 'Admin'; ?>
                </span>
                <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>