<?php
require_once '../config.php';
require_login();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = clean_input($_POST['title']);
    $description = clean_input($_POST['description']);
    $event_date = clean_input($_POST['event_date']);
    $time = clean_input($_POST['time']);
    $location = clean_input($_POST['location']);
    $organizer = clean_input($_POST['organizer']);
    $requirements = clean_input($_POST['requirements']);
    $contact_info = clean_input($_POST['contact_info']);
    
    // Validate form data
    if (empty($title) || empty($description) || empty($event_date) || empty($time) || empty($location) || empty($organizer)) {
        $error = "Field dengan tanda * harus diisi.";
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
            // Insert event into database
            $query = "INSERT INTO events (title, description, event_date, time, location, organizer, requirements, contact_info, image, created_at) 
                      VALUES ('$title', '$description', '$event_date', '$time', '$location', '$organizer', '$requirements', '$contact_info', '$image', NOW())";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Kegiatan berhasil ditambahkan.";
                redirect('events.php');
            } else {
                $error = "Terjadi kesalahan. Kegiatan gagal ditambahkan.";
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
    <title>Tambah Kegiatan - Admin Panel</title>
    
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
                            <a href="posts.php" class="nav-link">
                                <i class="bi bi-newspaper me-2"></i> Berita
                            </a>
                        </li>
                        <li>
                            <a href="events.php" class="nav-link active">
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
                    <h1 class="h2">Tambah Kegiatan Baru</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="events.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
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
                        <form action="add-event.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="organizer" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="organizer" name="organizer" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="event_date" class="form-label">Tanggal Kegiatan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="event_date" name="event_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="time" class="form-label">Waktu <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="time" name="time" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="requirements" class="form-label">Persyaratan</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="contact_info" class="form-label">Informasi Kontak</label>
                                <textarea class="form-control" id="contact_info" name="contact_info" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Format yang diperbolehkan: JPEG, JPG, PNG, GIF</div>
                                <img id="preview" class="preview-image mt-2 rounded" alt="Preview">
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <a href="events.php" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan Kegiatan</button>
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