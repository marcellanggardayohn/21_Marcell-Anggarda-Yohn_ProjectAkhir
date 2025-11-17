<?php
session_start();
include 'connect.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Search functionality
$search = '';
$where_conditions = [];
$query_params = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where_conditions[] = "(project_title LIKE '%$search%' OR project_type LIKE '%$search%' OR location LIKE '%$search%' OR status LIKE '%$search%')";
}

// Build query
$query = "SELECT id, user_id, project_title, project_type, location, project_description, preferred_date, status FROM projects";

if (!empty($where_conditions)) {
    $query .= " WHERE " . implode(' AND ', $where_conditions);
}

$query .= " ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2">Daftar Proyek</h1>
                <a href="users.php" class="btn btn-primary">Users List</a>
            </div>

            <!-- Search Bar -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search projects by title, type, location, or status..." value="<?php echo htmlspecialchars($search); ?>">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php if (!empty($search)): ?>
                                <a href="projects.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear Search
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Info -->
            <?php if (!empty($search)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Showing results for: "<strong><?php echo htmlspecialchars($search); ?></strong>"
                    <?php 
                    $count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM projects WHERE " . implode(' AND ', $where_conditions));
                    $count_row = mysqli_fetch_assoc($count_result);
                    echo " - Found " . $count_row['total'] . " project(s)";
                    ?>
                </div>
            <?php endif; ?>

            <!-- Projects Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Project Title</th>
                                    <th>Project Type</th>
                                    <th>Location</th>
                                    <th>Project Description</th>
                                    <th>Starting Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['user_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['project_title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['project_type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td>
                                            <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                                <?php echo htmlspecialchars($row['project_description']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $row['preferred_date']; ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                switch($row['status']) {
                                                    case 'active': echo 'success'; break;
                                                    case 'pending': echo 'warning'; break;
                                                    case 'completed': echo 'primary'; break;
                                                    default: echo 'secondary';
                                                }
                                            ?>">
                                                <?php echo htmlspecialchars($row['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="edit_project.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>
                                                <a href="delete_project.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <?php if (!empty($search)): ?>
                                                <i class="bi bi-search display-4 d-block mb-2"></i>
                                                No projects found for "<?php echo htmlspecialchars($search); ?>"
                                            <?php else: ?>
                                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                                No projects found
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.table th {
    background: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
}
.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
}
.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>