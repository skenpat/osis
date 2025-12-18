<?php
require_once '../config.php';
require_login();

// Get statistics
// Total posts
 $query_posts = "SELECT COUNT(*) as total FROM posts";
 $result_posts = mysqli_query($conn, $query_posts);
 $total_posts = mysqli_fetch_assoc($result_posts)['total'];

// Total events
 $query_events = "SELECT COUNT(*) as total FROM events";
 $result_events = mysqli_query($conn, $query_events);
 $total_events = mysqli_fetch_assoc($result_events)['total'];

// Total messages
 $query_messages = "SELECT COUNT(*) as total FROM contacts";
 $result_messages = mysqli_query($conn, $query_messages);
 $total_messages = mysqli_fetch_assoc($result_messages)['total'];

// Unread messages
 $query_unread = "SELECT COUNT(*) as total FROM contacts WHERE status = 'unread'";
 $result_unread = mysqli_query($conn, $query_unread);
 $unread_messages = mysqli_fetch_assoc($result_unread)['total'];

// Total members
 $query_members = "SELECT COUNT(*) as total FROM members";
 $result_members = mysqli_query($conn, $query_members);
 $total_members = mysqli_fetch_assoc($result_members)['total'];

// Get recent posts
 $query_recent_posts = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
 $result_recent_posts = mysqli_query($conn, $query_recent_posts);

// Get recent events
 $query_recent_events = "SELECT * FROM events ORDER BY created_at DESC LIMIT 5";
 $result_recent_events = mysqli_query($conn, $query_recent_events);

// Get recent messages
 $query_recent_messages = "SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5";
 $result_recent_messages = mysqli_query($conn, $query_recent_messages);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Panel</title>
    
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
        .stats-card {
            border-left: 4px solid;
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card.posts {
            border-left-color: #0d6efd;
        }
        .stats-card.events {
            border-left-color: #198754;
        }
        .stats-card.messages {
            border-left-color: #dc3545;
        }
        .stats-card.members {
            border-left-color: #fd7e14;
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
                            <a href="dashboard.php" class="nav-link active">
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
                            <a href="messages.php" class="nav-link">
                                <i class="bi bi-envelope me-2"></i> Pesan
                                <?php if ($unread_messages > 0): ?>
                                    <span class="badge bg-danger"><?php echo $unread_messages; ?></span>
                                <?php endif; ?>
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
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <span class="badge bg-primary"><?php echo date('d F Y'); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stats-card posts h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Artikel</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_posts; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-newspaper fs-2 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stats-card events h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kegiatan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_events; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-event fs-2 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stats-card messages h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pesan</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_messages; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-envelope fs-2 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stats-card members h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Anggota</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_members; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-people fs-2 text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Posts and Events -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Artikel Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <?php if (mysqli_num_rows($result_recent_posts) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Judul</th>
                                                    <th>Tanggal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($post = mysqli_fetch_assoc($result_recent_posts)): ?>
                                                    <tr>
                                                        <td><?php echo $post['title']; ?></td>
                                                        <td><?php echo format_date($post['created_at']); ?></td>
                                                        <td>
                                                            <a href="edit-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                                            <a href="delete-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')"><i class="bi bi-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <a href="posts.php" class="btn btn-outline-primary">Lihat Semua</a>
                                    </div>
                                <?php else: ?>
                                    <p>Belum ada artikel tersedia.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Kegiatan Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <?php if (mysqli_num_rows($result_recent_events) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama Kegiatan</th>
                                                    <th>Tanggal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($event = mysqli_fetch_assoc($result_recent_events)): ?>
                                                    <tr>
                                                        <td><?php echo $event['title']; ?></td>
                                                        <td><?php echo format_date($event['event_date']); ?></td>
                                                        <td>
                                                            <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                                            <a href="delete-event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')"><i class="bi bi-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <a href="events.php" class="btn btn-outline-success">Lihat Semua</a>
                                    </div>
                                <?php else: ?>
                                    <p>Belum ada kegiatan tersedia.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Messages -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Pesan Terbaru</h5>
                                <?php if ($unread_messages > 0): ?>
                                    <span class="badge bg-light text-dark"><?php echo $unread_messages; ?> Belum Dibaca</span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <?php if (mysqli_num_rows($result_recent_messages) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Subjek</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($message = mysqli_fetch_assoc($result_recent_messages)): ?>
                                                    <tr>
                                                        <td><?php echo $message['name']; ?></td>
                                                        <td><?php echo $message['subject']; ?></td>
                                                        <td><?php echo format_datetime($message['created_at']); ?></td>
                                                        <td>
                                                            <?php if ($message['status'] == 'unread'): ?>
                                                                <span class="badge bg-danger">Belum Dibaca</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-success">Dibaca</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="view-message.php?id=<?php echo $message['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                                            <a href="delete-message.php?id=<?php echo $message['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')"><i class="bi bi-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <a href="messages.php" class="btn btn-outline-danger">Lihat Semua</a>
                                    </div>
                                <?php else: ?>
                                    <p>Belum ada pesan tersedia.</p>
                                <?php endif; ?>
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