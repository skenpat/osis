<?php
require_once '../config.php';
require_login();

// Process delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $member_id = (int)$_GET['id'];
    
    // Get member photo
    $query = "SELECT photo FROM members WHERE id = $member_id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $member = mysqli_fetch_assoc($result);
        
        // Delete member from database
        $delete_query = "DELETE FROM members WHERE id = $member_id";
        
        if (mysqli_query($conn, $delete_query)) {
            // Delete photo file
            if (!empty($member['photo']) && file_exists('../uploads/' . $member['photo'])) {
                unlink('../uploads/' . $member['photo']);
            }
            
            $_SESSION['success'] = "Anggota berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan. Anggota gagal dihapus.";
        }
    }
    
    redirect('members.php');
}

// Pagination
 $limit = 10;
 $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
 $offset = ($page - 1) * $limit;

// Get total members
 $total_query = "SELECT COUNT(*) as total FROM members";
 $total_result = mysqli_query($conn, $total_query);
 $total_members = mysqli_fetch_assoc($total_result)['total'];
 $total_pages = ceil($total_members / $limit);

// Get members
 $query = "SELECT * FROM members ORDER BY created_at DESC LIMIT $offset, $limit";
 $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Anggota - Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --sidebar-width: 280px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fb;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--dark-color);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }
        
        .sidebar-logo i {
            font-size: 1.5rem;
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .sidebar-logo span {
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            display: block;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .menu-item i {
            margin-right: 15px;
            font-size: 1.1rem;
            width: 20px;
        }
        
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 30px;
        }
        
        .menu-item.active {
            background: var(--gradient);
            color: white;
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--accent-color);
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .user-role {
            font-size: 0.8rem;
            opacity: 0.7;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }
        
        .top-bar-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .notification-btn {
            position: relative;
            background: var(--light-color);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            transition: all 0.3s ease;
        }
        
        .notification-btn:hover {
            background: var(--gradient);
            color: white;
        }
        
        .logout-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Content Area */
        .content-area {
            padding: 30px;
        }
        
        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }
        
        .btn-add {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: white;
        }
        
        .btn-add i {
            margin-right: 8px;
        }
        
        /* Member Cards */
        .members-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .member-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .member-header {
            background: var(--gradient);
            padding: 20px;
            text-align: center;
            position: relative;
        }
        
        .member-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
            margin: 0 auto 15px;
        }
        
        .member-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }
        
        .member-position {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 5px;
        }
        
        .member-status {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
        }
        
        .status-active {
            background: #198754;
        }
        
        .status-inactive {
            background: #6c757d;
        }
        
        .member-body {
            padding: 20px;
        }
        
        .member-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .info-item i {
            color: var(--primary-color);
            width: 20px;
            text-align: center;
        }
        
        .member-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-action {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }
        
        .btn-edit {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .btn-edit:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .btn-delete:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 20px;
        }
        
        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
        }
        
        .empty-text {
            color: #6c757d;
            margin-bottom: 30px;
        }
        
        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }
        
        .page-link {
            color: var(--primary-color);
            border: none;
            margin: 0 5px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .page-link:hover {
            background: var(--gradient);
            color: white;
        }
        
        .page-item.active .page-link {
            background: var(--gradient);
            color: white;
        }
        
        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: var(--gradient);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .members-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .content-area {
                padding: 20px;
            }
            
            .top-bar {
                padding: 15px 20px;
            }
            
            .page-title {
                font-size: 1.2rem;
            }
            
            .members-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="bi bi-list"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="dashboard.php" class="sidebar-logo">
                <i class="bi bi-speedometer2"></i>
                <span>Admin Panel</span>
            </a>
        </div>
        <div class="sidebar-menu">
            <a href="dashboard.php" class="menu-item">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
            <a href="posts.php" class="menu-item">
                <i class="bi bi-newspaper"></i>
                <span>Artikel</span>
            </a>
            <a href="events.php" class="menu-item">
                <i class="bi bi-calendar-event"></i>
                <span>Kegiatan</span>
            </a>
            <a href="members.php" class="menu-item active">
                <i class="bi bi-people"></i>
                <span>Anggota</span>
            </a>
            <a href="messages.php" class="menu-item">
                <i class="bi bi-envelope"></i>
                <span>Pesan</span>
            </a>
            <a href="settings.php" class="menu-item">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </div>
        <div class="sidebar-footer">
            <a href="#" class="user-profile">
                <div class="user-avatar">
                    <i class="bi bi-person"></i>
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['admin_name']; ?></div>
                    <div class="user-role">Administrator</div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h1 class="page-title">Manajemen Anggota</h1>
            <div class="top-bar-actions">
                <button class="notification-btn">
                    <i class="bi bi-bell"></i>
                </button>
                <a href="logout.php" class="btn logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-area">
            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">Daftar Anggota</h2>
                <a href="add-member.php" class="btn-add">
                    <i class="bi bi-plus-circle"></i> Tambah Anggota
                </a>
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
            
            <!-- Member Cards -->
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="members-grid">
                    <?php while ($member = mysqli_fetch_assoc($result)): ?>
                        <div class="member-card">
                            <div class="member-header">
                                <div class="member-status <?php echo ($member['status'] == 'active') ? 'status-active' : 'status-inactive'; ?>"></div>
                                <?php if (!empty($member['photo'])): ?>
                                    <img src="../uploads/<?php echo $member['photo']; ?>" class="member-avatar" alt="<?php echo $member['name']; ?>">
                                <?php else: ?>
                                    <div class="member-avatar" style="background: rgba(255, 255, 255, 0.3); display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="font-size: 3rem; color: white;"></i>
                                    </div>
                                <?php endif; ?>
                                <h3 class="member-name"><?php echo $member['name']; ?></h3>
                                <div class="member-position"><?php echo $member['position']; ?></div>
                            </div>
                            <div class="member-body">
                                <div class="member-info">
                                    <div class="info-item">
                                        <i class="bi bi-mortarboard"></i>
                                        <span><?php echo $member['class']; ?></span>
                                    </div>
                                    <div class="info-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span><?php echo ($member['status'] == 'active') ? 'Aktif' : 'Tidak Aktif'; ?></span>
                                    </div>
                                    <div class="info-item">
                                        <i class="bi bi-calendar3"></i>
                                        <span><?php echo format_date($member['created_at']); ?></span>
                                    </div>
                                </div>
                                <div class="member-actions">
                                    <a href="edit-member.php?id=<?php echo $member['id']; ?>" class="btn-action btn-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="members.php?action=delete&id=<?php echo $member['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Anggota</h3>
                    <p class="empty-text">Tambahkan anggota OSIS untuk mulai mengelola data mereka.</p>
                    <a href="add-member.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Anggota Pertama
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <?php if ($i == $page): ?>
                                <li class="page-item active">
                                    <span class="page-link"><?php echo $i; ?></span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    </script>
</body>
</html>