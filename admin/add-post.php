<?php
require_once '../config.php';
require_login();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = clean_input($_POST['title']);
    $content = clean_input($_POST['content']);
    $category = clean_input($_POST['category']);
    $author = clean_input($_POST['author']);
    
    // Validate form data
    if (empty($title) || empty($content) || empty($category) || empty($author)) {
        $error = "Semua field harus diisi.";
    } else {
        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $file_name = time() . '_' . $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $upload_dir = '../uploads/';
                
                if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                    $image = $file_name;
                } else {
                    $error = "Gagal mengupload gambar.";
                }
            } else {
                $error = "Format gambar tidak valid. Hanya JPEG, JPG, PNG, dan GIF yang diperbolehkan.";
            }
        }
        
        if (!isset($error)) {
            // Insert post into database
            $query = "INSERT INTO posts (title, content, category, author, image, created_at) 
                      VALUES ('$title', '$content', '$category', '$author', '$image', NOW())";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Artikel berhasil ditambahkan.";
                redirect('posts.php');
            } else {
                $error = "Terjadi kesalahan. Artikel gagal ditambahkan.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel - Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="d-flex flex-column p-3 text-white">
                    <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span class="fs-4">Admin Panel</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="posts.php" class="nav-link active">
                                <i class="bi bi-newspaper me-2"></i> Artikel
                            </a>
                        </li>
                        <li>
                            <a href="events.php" class="nav-link">
                                <i class="bi bi-calendar-event me-2"></i> Kegiatan
                            </a>
                        </li>
                        <li>
                            <a href="members.php" class="nav-link">
                                <i class="bi bi-people me-2"></i> Anggota
                            </a>
                        </li>
                        <li>
                            <a href="messages.php" class="nav-link">
                                <i class="bi bi-envelope me-2"></i> Pesan
                            </a>
                        </li>
                        <li>
                            <a href="settings.php" class="nav-link">
                                <i class="bi bi-gear me-2"></i> Pengaturan
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>
                            <strong><?php echo $_SESSION['admin_name']; ?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tambah Artikel Baru</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="posts.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="add-post.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Artikel</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pengumuman">Pengumuman</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Prestasi">Prestasi</option>
                                    <option value="Umum">Umum</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="author" class="form-label">Penulis</label>
                                <input type="text" class="form-control" id="author" name="author" value="<?php echo $_SESSION['admin_name']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Format yang diperbolehkan: JPEG, JPG, PNG, GIF</div>
                                <img id="preview" class="preview-image mt-2 rounded" alt="Preview">
                            </div>
                            
                            <div class="mb-3">
                                <label for="content" class="form-label">Isi Artikel</label>
                                <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <a href="posts.php" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Artikel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    <script>
        // Preview image before upload
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(e.target.files[0]);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
</body>
</html>