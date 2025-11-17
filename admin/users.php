<?php
session_start();
include 'connect.php';

// Cek login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Search functionality
$search = '';
$where_conditions = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where_conditions[] = "(fullname LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
}

// Build query
$sql = "SELECT id, fullname, username, email, phone FROM users";

if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(' AND ', $where_conditions);
}

$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$users = [];
if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Proses tambah user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    if (!empty($fullname) && !empty($username) && !empty($email) && !empty($password)) {
        // Cek username unique
        $check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
        if (mysqli_num_rows($check) == 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO users (fullname, username, email, phone, password) 
                          VALUES ('$fullname', '$username', '$email', '$phone', '$hashed_password')";
            
            if (mysqli_query($conn, $insert_sql)) {
                header("Location: users.php?success=1");
                exit;
            } else {
                $error = "Gagal menambahkan user!";
            }
        } else {
            $error = "Username sudah digunakan!";
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Users Management</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    + Add User
                </button>
            </div>

            <!-- Search Bar -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search users by name, username, email, or phone..." value="<?php echo htmlspecialchars($search); ?>">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php if (!empty($search)): ?>
                                <a href="users.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear Search
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    User berhasil ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Results Info -->
            <?php if (!empty($search)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Showing results for: "<strong><?php echo htmlspecialchars($search); ?></strong>"
                    - Found <?php echo count($users); ?> user(s)
                </div>
            <?php endif; ?>

            <!-- Users Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <?php if (!empty($search)): ?>
                                                <i class="bi bi-search display-4 d-block mb-2"></i>
                                                No users found for "<?php echo htmlspecialchars($search); ?>"
                                            <?php else: ?>
                                                <i class="bi bi-people display-4 d-block mb-2"></i>
                                                No users found
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($users as $index => $user): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar">
                                                    <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
                                                </div>
                                                <?php echo htmlspecialchars($user['fullname']); ?>
                                            </div>
                                        </td>
                                        <td>@<?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['phone'] ?: '-'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 10px;
}
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
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>