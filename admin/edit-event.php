<?php
require_once '../config.php';
require_login();

// Get event ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('events.php');
}

 $event_id = (int)$_GET['id'];

// Get event data
 $query = "SELECT * FROM events WHERE id = $event_id";
 $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    redirect('events.php');
}

 $event = mysqli_fetch_assoc($result);

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
    $current_image = $event['image'];
    
    // Validate form data
    if (empty($title) || empty($description) || empty($event_date) || empty($time) || empty($location) || empty($organizer)) {
        $error = "Field dengan tanda * harus diisi.";
    } else {
        // Handle image upload
        $image = $current_image;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $file_name = time() . '_' . $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $upload_dir = '../uploads/';
                
                if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                    // Delete old image if exists
                    if (!empty($current_image) && file_exists($upload_dir . $current_image)) {
                        unlink($upload_dir . $current_image);
                    }
                    
                    $image = $file_name;
                } else {
                    $error = "Gagal mengupload gambar.";
                }
            } else {
                $error = "Format gambar tidak valid. Hanya JPEG, JPG, PNG, dan GIF yang diperbolehkan.";
            }
        }
        
        if (!isset($error)) {
            // Update event in database
            $query = "UPDATE events SET 
                      title = '$title', 
                      description = '$description', 
                      event_date = '$event_date', 
                      time = '$time', 
                      location = '$location', 
                      organizer = '$organizer', 
                      requirements = '$requirements', 
                      contact_info = '$contact_info', 
                      image = '$image' 
                      WHERE id = $event_id";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Kegiatan berhasil diperbarui.";
                redirect('events.php');
            } else {
                $error = "Terjadi kesalahan. Kegiatan gagal diperbarui.";
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
    <title>Edit Kegiatan - Admin Panel</title>
    
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
                    <h1 class="h2">Edit Kegiatan</h1>
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
                        <form action="edit-event.php?id=<?php echo $event_id; ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $event['title']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="organizer" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="organizer" name="organizer" value="<?php echo $event['organizer']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="event_date" class="form-label">Tanggal Kegiatan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="time" class="form-label">Waktu <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" id="time" name="time" value="<?php echo $event['time']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" value="<?php echo $event['location']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $event['description']; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="requirements" class="form-label">Persyaratan</label>
                                <textarea class="form-control" id="requirements" name="requirements" rows="3"><?php echo $event['requirements']; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="contact_info" class="form-label">Informasi Kontak</label>
                                <textarea class="form-control" id="contact_info" name="contact_info" rows="3"><?php echo $event['contact_info']; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Format yang diperbolehkan: JPEG, JPG, PNG, GIF. Kosongkan jika tidak ingin mengubah gambar.</div>
                                <?php if (!empty($event['image'])): ?>
                                    <img id="preview" class="preview-image mt-2 rounded" src="../uploads/<?php echo $event['image']; ?>" alt="Preview">
                                <?php endif; ?>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <a href="events.php" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-success">Update Kegiatan</button>
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
            }
        });
    </script>
</body>
</html>