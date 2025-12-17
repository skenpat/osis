<?php
// admin/posts.php - Manajemen Berita
session_start();
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

include '../config.php';

// Hapus post
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE id = $id";
    if ($conn->query($query)) {
        $_SESSION['success'] = "Berita berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus berita!";
    }
    redirect('posts.php');
}

// Ambil semua posts
 $query = "SELECT * FROM posts ORDER BY created_at DESC";
 $result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita - Admin OSIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #34495e;
            color: white;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-center">Admin Panel</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="dashboard.php">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a class="nav-link active" href="posts.php">
                        <i class="bi bi-newspaper me-2"></i> Berita
                    </a>
                    <a class="nav-link" href="events.php">
                        <i class="bi bi-calendar-event me-2"></i> Kegiatan
                    </a>
                    <a class="nav-link" href="members.php">
                        <i class="bi bi-people me-2"></i> Anggota
                    </a>
                    <a class="nav-link" href="messages.php">
                        <i class="bi bi-envelope me-2"></i> Pesan
                    </a>
                    <a class="nav-link" href="settings.php">
                        <i class="bi bi-gear me-2"></i> Pengaturan
                    </a>
                    <a class="nav-link" href="logout.php">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Topbar -->
                <div class="bg-white border-bottom p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manajemen Berita</h5>
                        <a href="add-post.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Berita
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Penulis</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php while ($post = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td>
                                                        <?php if ($post['image']): ?>
                                                            <img src="uploads/<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" width="60" class="rounded">
                                                        <?php else: ?>
                                                            <img src="https://picsum.photos/seed/<?php echo $post['id']; ?>/60/60" alt="No image" width="60" class="rounded">
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $post['title']; ?></td>
                                                    <td><span class="badge bg-secondary"><?php echo $post['category']; ?></span></td>
                                                    <td><?php echo $post['author']; ?></td>
                                                    <td><?php echo date('d M Y', strtotime($post['created_at'])); ?></td>
                                                    <td>
                                                        <a href="edit-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="posts.php?delete=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Belum ada berita.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
