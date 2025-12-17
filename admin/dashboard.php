<?php
// admin/dashboard.php - Dashboard Admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

include '../config.php';

// Statistik dashboard
 $query_posts = "SELECT COUNT(*) as total FROM posts";
 $result_posts = $conn->query($query_posts);
 $total_posts = $result_posts->fetch_assoc()['total'];

 $query_events = "SELECT COUNT(*) as total FROM events";
 $result_events = $conn->query($query_events);
 $total_events = $result_events->fetch_assoc()['total'];

 $query_members = "SELECT COUNT(*) as total FROM members";
 $result_members = $conn->query($query_members);
 $total_members = $result_members->fetch_assoc()['total'];

 $query_messages = "SELECT COUNT(*) as total FROM contacts WHERE status = 'unread'";
 $result_messages = $conn->query($query_messages);
 $unread_messages = $result_messages->fetch_assoc()['total'];

// Recent posts
 $query_recent_posts = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
 $result_recent_posts = $conn->query($query_recent_posts);

// Recent events
 $query_recent_events = "SELECT * FROM events ORDER BY created_at DESC LIMIT 5";
 $result_recent_events = $conn->query($query_recent_events);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin OSIS</title>
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
        .stat-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
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
                    <a class="nav-link active" href="dashboard.php">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="posts.php">
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
                        <?php if ($unread_messages > 0): ?>
                            <span class="badge bg-danger"><?php echo $unread_messages; ?></span>
                        <?php endif; ?>
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
                        <h5 class="mb-0">Dashboard</h5>
                        <div class="d-flex align-items-center">
                            <span class="me-3">Selamat datang, <?php echo $_SESSION['admin_name']; ?></span>
                            <img src="https://picsum.photos/seed/admin/40/40" class="rounded-circle" alt="Admin">
                        </div>
                    </div>
                </div>

                <!-- Dashboard Content -->
                <div class="p-4">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Berita</h6>
                                            <h2 class="mb-0"><?php echo $total_posts; ?></h2>
                                        </div>
                                        <i class="bi bi-newspaper fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Kegiatan</h6>
                                            <h2 class="mb-0"><?php echo $total_events; ?></h2>
                                        </div>
                                        <i class="bi bi-calendar-event fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Total Anggota</h6>
                                            <h2 class="mb-0"><?php echo $total_members; ?></h2>
                                        </div>
                                        <i class="bi bi-people fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="card-title">Pesan Baru</h6>
                                            <h2 class="mb-0"><?php echo $unread_messages; ?></h2>
                                        </div>
                                        <i class="bi bi-envelope fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Posts and Events -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Berita Terbaru</h5>
                                </div>
                                <div class="card-body">
                                    <?php if ($result_recent_posts->num_rows > 0): ?>
                                        <div class="list-group list-group-flush">
                                            <?php while ($post = $result_recent_posts->fetch_assoc()): ?>
                                                <div class="list-group-item px-0">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="mb-1"><?php echo $post['title']; ?></h6>
                                                            <small class="text-muted"><?php echo date('d M Y', strtotime($post['created_at'])); ?></small>
                                                        </div>
                                                        <a href="edit-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Belum ada berita.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Kegiatan Terbaru</h5>
                                </div>
                                <div class="card-body">
                                    <?php if ($result_recent_events->num_rows > 0): ?>
                                        <div class="list-group list-group-flush">
                                            <?php while ($event = $result_recent_events->fetch_assoc()): ?>
                                                <div class="list-group-item px-0">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="mb-1"><?php echo $event['title']; ?></h6>
                                                            <small class="text-muted"><?php echo date('d M Y', strtotime($event['event_date'])); ?></small>
                                                        </div>
                                                        <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Belum ada kegiatan.</p>
                                    <?php endif; ?>
                                </div>
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
