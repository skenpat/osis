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
        
        /* Message Card */
        .message-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .message-header {
            background: var(--gradient);
            color: white;
            padding: 20px 25px;
            position: relative;
        }
        
        .message-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }
        
        .message-meta {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .message-meta-item {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .message-meta-item i {
            margin-right: 8px;
        }
        
        .message-body {
            padding: 30px;
        }
        
        .message-content {
            color: #333;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .contact-info {
            background: var(--light-color);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .contact-info h5 {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
        }
        
        .contact-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .contact-info-item i {
            width: 30px;
            text-align: center;
            color: var(--primary-color);
            margin-right: 15px;
        }
        
        .message-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            border-top: 1px solid #f1f3f7;
        }
        
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            margin: 0 5px;
        }
        
        .btn-reply {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .btn-reply:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-mark-read {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .btn-mark-read:hover {
            background: #198754;
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
            
            .message-header {
                padding: 15px 20px;
            }
            
            .message-meta {
                flex-direction: column;
                gap: 10px;
            }
            
            .message-actions {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn-action {
                margin: 0;
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
            <a href="members.php" class="menu-item">
                <i class="bi bi-people"></i>
                <span>Anggota</span>
            </a>
            <a href="messages.php" class="menu-item active">
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
            <h1 class="page-title">Detail Pesan</h1>
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
            <div class="message-card">
                <div class="message-header">
                    <h2 class="message-title"><?php echo $message['subject']; ?></h2>
                    <div class="message-meta">
                        <div class="message-meta-item">
                            <i class="bi bi-person"></i>
                            <span><?php echo $message['name']; ?></span>
                        </div>
                        <div class="message-meta-item">
                            <i class="bi bi-envelope"></i>
                            <span><?php echo $message['email']; ?></span>
                        </div>
                        <div class="message-meta-item">
                            <i class="bi bi-calendar3"></i>
                            <span><?php echo format_datetime($message['created_at']); ?></span>
                        </div>
                    </div>
                </div>
                <div class="message-body">
                    <div class="message-content">
                        <?php echo nl2br($message['message']); ?>
                    </div>
                </div>
                <div class="contact-info">
                    <h5>Informasi Kontak</h5>
                    <div class="contact-info-item">
                        <i class="bi bi-person"></i>
                        <span><?php echo $message['name']; ?></span>
                    </div>
                    <div class="contact-info-item">
                        <i class="bi bi-envelope"></i>
                        <span><?php echo $message['email']; ?></span>
                    </div>
                    <div class="contact-info-item">
                        <i class="bi bi-telephone"></i>
                        <span><?php echo $message['phone']; ?></span>
                    </div>
                </div>
                <div class="message-actions">
                    <a href="mailto:<?php echo $message['email']; ?>?subject=Re: <?php echo $message['subject']; ?>" class="btn-action btn-reply">
                        <i class="bi bi-reply"></i>
                    </a>
                    <?php if ($message['status'] == 'unread'): ?>
                        <a href="messages.php?action=mark-read&id=<?php echo $message['id']; ?>" class="btn-action btn-mark-read">
                            <i class="bi bi-check-circle"></i>
                        </a>
                    <?php endif; ?>
                    <a href="messages.php?action=delete&id=<?php echo $message['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        </div>
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