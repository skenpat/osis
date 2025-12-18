<?php
require_once '../config.php';
require_login();

// Get message ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('messages.php');
}

 $message_id = (int)$_GET['id'];

// Get message data
 $query = "SELECT * FROM contacts WHERE id = $message_id";
 $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    redirect('messages.php');
}

 $message = mysqli_fetch_assoc($result);

// Mark message as read
if ($message['status'] == 'unread') {
    $update_query = "UPDATE contacts SET status = 'read' WHERE id = $message_id";
    mysqli_query($conn, $update_query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesan - Admin Panel</title>
    
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
                            <a href="members.php" class="nav-link">
                                <i class="bi bi-people me-2"></i> Anggota
                            </a>
                        </li>
                        <li>
                            <a href="messages.php" class="nav-link active">
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
                    <h1 class="h2">Detail Pesan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="messages.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo $message['subject']; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Nama:</strong> <?php echo $message['name']; ?></p>
                                <p><strong>Email:</strong> <?php echo $message['email']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tanggal:</strong> <?php echo format_datetime($message['created_at']); ?></p>
                                <p><strong>Status:</strong> 
                                    <?php if ($message['status'] == 'read'): ?>
                                        <span class="badge bg-success">Dibaca</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Belum Dibaca</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Isi Pesan</h5>
                            <div class="border rounded p-3 bg-light">
                                <?php echo nl2br($message['message']); ?>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="mailto:<?php echo $message['email']; ?>?subject=Re: <?php echo $message['subject']; ?>" class="btn btn-primary">
                                    <i class="bi bi-reply"></i> Balas Email
                                </a>
                            </div>
                            <div>
                                <a href="messages.php?action=delete&id=<?php echo $message['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                    <i class="bi bi-trash"></i> Hapus Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
</body>
</html>