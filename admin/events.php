<?php
require_once '../config.php';
require_login();

// Process delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $event_id = (int)$_GET['id'];
    
    // Get event image
    $query = "SELECT image FROM events WHERE id = $event_id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $event = mysqli_fetch_assoc($result);
        
        // Delete event from database
        $delete_query = "DELETE FROM events WHERE id = $event_id";
        
        if (mysqli_query($conn, $delete_query)) {
            // Delete image file
            if (!empty($event['image']) && file_exists('../uploads/' . $event['image'])) {
                unlink('../uploads/' . $event['image']);
            }
            
            $_SESSION['success'] = "Kegiatan berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan. Kegiatan gagal dihapus.";
        }
    }
    
    redirect('events.php');
}

// Pagination
 $limit = 10;
 $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
 $offset = ($page - 1) * $limit;

// Get total events
 $total_query = "SELECT COUNT(*) as total FROM events";
 $total_result = mysqli_query($conn, $total_query);
 $total_events = mysqli_fetch_assoc($total_result)['total'];
 $total_pages = ceil($total_events / $limit);

// Get events
 $query = "SELECT * FROM events ORDER BY event_date DESC LIMIT $offset, $limit";
 $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kegiatan - Admin Panel</title>
    
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
                    <h1 class="h2">Manajemen Kegiatan</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="add-event.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Kegiatan</a>
                        </div>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Kegiatan</th>
                                            <th>Tanggal</th>
                                            <th>Lokasi</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = $offset + 1; while ($event = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $event['title']; ?></td>
                                                <td><?php echo format_date($event['event_date']); ?></td>
                                                <td><?php echo $event['location']; ?></td>
                                                <td><?php echo $event['organizer']; ?></td>
                                                <td>
                                                    <?php
                                                    $event_date = strtotime($event['event_date']);
                                                    $current_date = strtotime(date('Y-m-d'));
                                                    
                                                    if ($event_date > $current_date) {
                                                        echo '<span class="badge bg-primary">Akan Datang</span>';
                                                    } elseif ($event_date == $current_date) {
                                                        echo '<span class="badge bg-success">Hari Ini</span>';
                                                    } else {
                                                        echo '<span class="badge bg-secondary">Selesai</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="../event-detail.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-info" target="_blank"><i class="bi bi-eye"></i></a>
                                                    <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="events.php?action=delete&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <?php if ($total_pages > 1): ?>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                <p class="mt-2">Belum ada kegiatan tersedia.</p>
                                <a href="add-event.php" class="btn btn-success">Tambah Kegiatan Baru</a>
                            </div>
                        <?php endif; ?>
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