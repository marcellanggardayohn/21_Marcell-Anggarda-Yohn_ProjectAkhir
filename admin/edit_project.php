<?php
session_start();
include 'connect.php';

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: projects.php?error=ID proyek tidak valid");
    exit;
}

// Ambil data proyek berdasarkan ID
$stmt = mysqli_prepare($conn, "SELECT project_title, project_type, location, project_description, preferred_date, status FROM projects WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    header("Location: projects.php?error=Proyek tidak ditemukan");
    exit;
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_title = trim($_POST['project_title']);
    $project_type = trim($_POST['project_type']);
    $location = trim($_POST['location']);
    $project_description = trim($_POST['project_description']);
    $preferred_date = $_POST['preferred_date'];
    $status = trim($_POST['status']);

    // Validasi sederhana
    if (empty($project_title) || empty($project_type) || empty($location) || empty($project_description) || empty($preferred_date) || empty($status)) {
        $error = "Semua field harus diisi!";
    } else {
        $update_stmt = mysqli_prepare($conn, "UPDATE projects SET project_title = ?, project_type = ?, location = ?, project_description = ?, preferred_date = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stmt, "ssssssi", $project_title, $project_type, $location, $project_description, $preferred_date, $status, $id);
        if (mysqli_stmt_execute($update_stmt)) {
            header("Location: projects.php?success=Proyek berhasil diperbarui");
            exit;
        } else {
            $error = "Gagal memperbarui proyek: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek - McKingsley Contractor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Proyek</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="project_title" class="form-label">Judul Proyek</label>
                <input type="text" class="form-control" id="project_title" name="project_title" value="<?php echo htmlspecialchars($project['project_title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="project_type" class="form-label">Tipe Proyek</label>
                <input type="text" class="form-control" id="project_type" name="project_type" value="<?php echo htmlspecialchars($project['project_type']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($project['location']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="project_description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="project_description" name="project_description" rows="3" required><?php echo htmlspecialchars($project['project_description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="preferred_date" class="form-label">Tanggal Preferensi</label>
                <input type="date" class="form-control" id="preferred_date" name="preferred_date" value="<?php echo $project['preferred_date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="In Progress" <?php if ($project['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                    <option value="Completed" <?php if ($project['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Pending Review" <?php if ($project['status'] == 'Pending Review') echo 'selected'; ?>>Pending Review</option>
                    <option value="Approved" <?php if ($project['status'] == 'Approved') echo 'selected'; ?>>Approved</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="projects.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
