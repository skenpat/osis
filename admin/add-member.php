<?php
require_once '../config.php';
require_login();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST['name']);
    $position = clean_input($_POST['position']);
    $class = clean_input($_POST['class']);
    $status = clean_input($_POST['status']);
    
    // Validate form data
    if (empty($name) || empty($position) || empty($class) || empty($status)) {
        $error = "Semua field harus diisi.";
    } else {
        // Handle photo upload
        $photo = '';
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES['photo']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $file_name = time() . '_' . $_FILES['photo']['name'];
                $file_tmp = $_FILES['photo']['tmp_name'];
                $upload_dir = '../uploads/';
                
                if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                    $photo = $file_name;
                } else {
                    $error = "Gagal mengupload foto.";
                }
            } else {
                $error = "Format foto tidak valid. Hanya JPEG, JPG, PNG, dan GIF yang diperbolehkan.";
            }
        }
        
        if (!isset($error)) {
            // Insert member into database
            $query = "INSERT INTO members (name, position, class, status, photo, created_at) 
                      VALUES ('$name', '$position', '$class', '$status', '$photo', NOW())";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Anggota berhasil ditambahkan.";
                redirect('members.php');
            } else {
                $error = "Terjadi kesalahan. Anggota gagal ditambahkan.";
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
    <title>Tambah Anggota - Admin Panel</title>
    
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
            border-radius: 50%;
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
                            <a href="posts.php" class="nav-link">
                                <i class="bi bi-newspaper me-2"></i> Artikel
                            </a>
                        </li>
                        <li>
                            <a href="events.php" class="nav-link">
                                <i class="bi bi-calendar-event me-2"></i> Kegiatan
                            </a>
                        </li>
                        <li>
                            <a href="members.php" class="nav-link active">
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
                    <h1 class="h2">Tambah Anggota Baru</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="members.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
                        <form action="add-member.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" id="position" name="position" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="class" class="form-label">Kelas</label>
                                        <input type="text" class="form-control" id="class" name="class" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="active">Aktif</option>
                                            <option value="inactive">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                <div class="form-text">Format yang diperbolehkan: JPEG, JPG, PNG, GIF</div>
                                <img id="preview" class="preview-image mt-2" alt="Preview">
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <a href="members.php" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-warning">Simpan Anggota</button>
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
        document.getElementById('photo').addEventListener('change', function(e) {
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