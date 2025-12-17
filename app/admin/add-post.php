<?php
// admin/add-post.php - Tambah Berita Baru
session_start();
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = clean_input($_POST['title']);
    $content = clean_input($_POST['content']);
    $category = clean_input($_POST['category']);
    $author = clean_input($_POST['author']);
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }
    
    $query = "INSERT INTO posts (title, content, category, author, image) 
              VALUES ('$title', '$content', '$category', '$author', '$image')";
    
    if ($conn->query($query)) {
        $_SESSION['success'] = "Berita berhasil ditambahkan!";
        redirect('posts.php');
    } else {
        $_SESSION['error'] = "Gagal menambahkan berita!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita - Admin OSIS</title>
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
                        <h5 class="mb-0">Tambah Berita Baru</h5>
                        <a href="posts.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Judul Berita</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-select" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Pengumuman">Pengumuman</option>
                                        <option value="Kegiatan">Kegiatan</option>
                                        <option value="Prestasi">Prestasi</option>
                                        <option value="Umum">Umum</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penulis</label>
                                    <input type="text" class="form-control" name="author" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konten</label>
                                    <textarea class="form-control" name="content" rows="10" required></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                                    <a href="posts.php" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
