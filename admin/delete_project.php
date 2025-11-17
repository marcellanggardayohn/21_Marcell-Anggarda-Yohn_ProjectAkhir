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

// Ambil data proyek untuk konfirmasi
$stmt = mysqli_prepare($conn, "SELECT project_title, project_type, location FROM projects WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    header("Location: projects.php?error=Proyek tidak ditemukan");
    exit;
}

// Proses delete jika konfirmasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete'])) {
        $delete_stmt = mysqli_prepare($conn, "DELETE FROM projects WHERE id = ?");
        mysqli_stmt_bind_param($delete_stmt, "i", $id);
        
        if (mysqli_stmt_execute($delete_stmt)) {
            header("Location: projects.php?success=Proyek berhasil dihapus");
            exit;
        } else {
            $error = "Gagal menghapus proyek: " . mysqli_error($conn);
        }
    } else {
        // Jika batal, kembali ke halaman projects
        header("Location: projects.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Proyek - McKingsley Contractor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="delete.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Hapus Proyek</h1>
            <a href="projects.php" class="btn btn-outline-secondary">← Kembali ke Daftar Proyek</a>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="confirmation-box">
            <div class="warning-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h2>Konfirmasi Penghapusan</h2>
            <p class="warning-text">Anda akan menghapus proyek berikut. Tindakan ini tidak dapat dibatalkan!</p>
            
            <div class="project-details">
                <h5>Detail Proyek:</h5>
                <div class="detail-item">
                    <strong>Judul Proyek:</strong>
                    <span><?php echo htmlspecialchars($project['project_title']); ?></span>
                </div>
                <div class="detail-item">
                    <strong>Tipe Proyek:</strong>
                    <span><?php echo htmlspecialchars($project['project_type']); ?></span>
                </div>
                <div class="detail-item">
                    <strong>Lokasi:</strong>
                    <span><?php echo htmlspecialchars($project['location']); ?></span>
                </div>
            </div>

            <form method="POST" class="confirmation-form">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirmCheck" required>
                    <label class="form-check-label" for="confirmCheck">
                        Saya memahami bahwa tindakan ini tidak dapat dibatalkan
                    </label>
                </div>

                <div class="button-group">
                    <a href="projects.php" class="btn btn-secondary">Batal</a>
                    <button type="submit" name="confirm_delete" class="btn btn-danger" id="deleteBtn" disabled>
                        Hapus Proyek
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable delete button only when checkbox is checked
        document.getElementById('confirmCheck').addEventListener('change', function() {
            document.getElementById('deleteBtn').disabled = !this.checked;
        });

        // Confirmation before delete
        document.querySelector('.confirmation-form').addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus proyek ini?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>