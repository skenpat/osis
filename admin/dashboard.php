<?php
require_once '../config.php';
require_login();

// Get statistics with secure queries
// Total posts
 $stmt_posts = $conn->prepare("SELECT COUNT(*) as total FROM posts");
 $stmt_posts->execute();
 $total_posts = $stmt_posts->get_result()->fetch_assoc()['total'];

// Total events
 $stmt_events = $conn->prepare("SELECT COUNT(*) as total FROM events");
 $stmt_events->execute();
 $total_events = $stmt_events->get_result()->fetch_assoc()['total'];

// Total messages
 $stmt_messages = $conn->prepare("SELECT COUNT(*) as total FROM contacts");
 $stmt_messages->execute();
 $total_messages = $stmt_messages->get_result()->fetch_assoc()['total'];

// Unread messages
 $stmt_unread = $conn->prepare("SELECT COUNT(*) as total FROM contacts WHERE status = ?");
 $unread_status = 'unread';
 $stmt_unread->bind_param("s", $unread_status);
 $stmt_unread->execute();
 $unread_messages = $stmt_unread->get_result()->fetch_assoc()['total'];

// Total members
 $stmt_members = $conn->prepare("SELECT COUNT(*) as total FROM members");
 $stmt_members->execute();
 $total_members = $stmt_members->get_result()->fetch_assoc()['total'];

// Get recent posts with prepared statement
 $stmt_recent_posts = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5");
 $stmt_recent_posts->execute();
 $result_recent_posts = $stmt_recent_posts->get_result();

// Get recent events with prepared statement
 $stmt_recent_events = $conn->prepare("SELECT * FROM events ORDER BY created_at DESC LIMIT 5");
 $stmt_recent_events->execute();
 $result_recent_events = $stmt_recent_events->get_result();

// Get recent messages with prepared statement
 $stmt_recent_messages = $conn->prepare("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");
 $stmt_recent_messages->execute();
 $result_recent_messages = $stmt_recent_messages->get_result();
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
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
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent-color);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .logout-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Content Area */
        .content-area {
            padding: 30px;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card.posts::before {
            background: var(--primary-color);
        }
        
        .stat-card.events::before {
            background: #198754;
        }
        
        .stat-card.messages::before {
            background: #dc3545;
        }
        
        .stat-card.members::before {
            background: #fd7e14;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-card.posts .stat-icon {
            background: var(--primary-color);
        }
        
        .stat-card.events .stat-icon {
            background: #198754;
        }
        
        .stat-card.messages .stat-icon {
            background: #dc3545;
        }
        
        .stat-card.members .stat-icon {
            background: #fd7e14;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-change {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 20px;
        }
        
        .stat-change.positive {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .stat-change.negative {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }
        
        .chart-options {
            display: flex;
            gap: 10px;
        }
        
        .chart-option {
            padding: 5px 15px;
            border: 1px solid #e9ecef;
            background: white;
            border-radius: 20px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .chart-option.active {
            background: var(--gradient);
            color: white;
            border-color: transparent;
        }
        
        /* Recent Activity */
        .activity-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .activity-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }
        
        .activity-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .activity-item {
            display: flex;
            align-items: flex-start;
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f7;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .activity-icon.post {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .activity-icon.event {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        
        .activity-icon.message {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 5px;
        }
        
        .activity-time {
            font-size: 0.8rem;
            color: #6c757d;
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
        @media (max-width: 1200px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
        }
        
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
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            <a href="dashboard.php" class="menu-item active">
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
            <h1 class="page-title">Dashboard</h1>
            <div class="top-bar-actions">
                <button class="notification-btn">
                    <i class="bi bi-bell"></i>
                    <?php if ($unread_messages > 0): ?>
                        <span class="notification-badge"><?php echo $unread_messages; ?></span>
                    <?php endif; ?>
                </button>
                <a href="logout.php" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-area">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card posts">
                    <div class="stat-icon">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="stat-value"><?php echo $total_posts; ?></div>
                    <div class="stat-label">Total Artikel</div>
                    <div class="stat-change positive">+12%</div>
                </div>
                <div class="stat-card events">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="stat-value"><?php echo $total_events; ?></div>
                    <div class="stat-label">Total Kegiatan</div>
                    <div class="stat-change positive">+8%</div>
                </div>
                <div class="stat-card messages">
                    <div class="stat-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="stat-value"><?php echo $total_messages; ?></div>
                    <div class="stat-label">Total Pesan</div>
                    <div class="stat-change negative">-3%</div>
                </div>
                <div class="stat-card members">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-value"><?php echo $total_members; ?></div>
                    <div class="stat-label">Total Anggota</div>
                    <div class="stat-change positive">+15%</div>
                </div>
            </div>
            
            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Aktivitas Bulanan</h3>
                        <div class="chart-options">
                            <div class="chart-option active">Bulan Ini</div>
                            <div class="chart-option">Tahun Ini</div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="activityChart" height="100"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Kategori Konten</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="categoryChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="activity-card">
                <div class="chart-header">
                    <h3 class="chart-title">Aktivitas Terbaru</h3>
                    <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="activity-list">
                    <?php if (mysqli_num_rows($result_recent_posts) > 0): ?>
                        <?php while ($post = mysqli_fetch_assoc($result_recent_posts)): ?>
                            <div class="activity-item">
                                <div class="activity-icon post">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Artikel baru: <?php echo $post['title']; ?></div>
                                    <div class="activity-time"><?php echo format_datetime($post['created_at']); ?></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    
                    <?php if (mysqli_num_rows($result_recent_events) > 0): ?>
                        <?php while ($event = mysqli_fetch_assoc($result_recent_events)): ?>
                            <div class="activity-item">
                                <div class="activity-icon event">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Kegiatan baru: <?php echo $event['title']; ?></div>
                                    <div class="activity-time"><?php echo format_datetime($event['created_at']); ?></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    
                    <?php if (mysqli_num_rows($result_recent_messages) > 0): ?>
                        <?php while ($message = mysqli_fetch_assoc($result_recent_messages)): ?>
                            <div class="activity-item">
                                <div class="activity-icon message">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">Pesan dari: <?php echo $message['name']; ?></div>
                                    <div class="activity-time"><?php echo format_datetime($message['created_at']); ?></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
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
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = mobileMenuToggle.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
        
        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Artikel',
                    data: [12, 19, 15, 25, 22, 30],
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Kegiatan',
                    data: [8, 12, 10, 15, 18, 20],
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pengumuman', 'Kegiatan', 'Prestasi', 'Umum'],
                datasets: [{
                    data: [30, 25, 20, 25],
                    backgroundColor: [
                        '#4361ee',
                        '#198754',
                        '#fd7e14',
                        '#6c757d'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Chart options
        const chartOptions = document.querySelectorAll('.chart-option');
        chartOptions.forEach(option => {
            option.addEventListener('click', function() {
                chartOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                // Here you would typically update the chart data based on the selected option
                // For now, we're just changing the active state
            });
        });
    </script>
</body>
</html>