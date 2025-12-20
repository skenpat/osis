<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel - <?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        /* Page Header */
        .page-header {
            background: var(--gradient);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') center/cover;
            opacity: 0.15;
            z-index: 0;
        }
        
        .page-header-content {
            position: relative;
            z-index: 1;
        }
        
        .page-title {
            font-weight: 800;
            margin-bottom: 1rem;
            font-size: 3rem;
        }
        
        .page-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
        }
        
        /* Blog Content */
        .blog-section {
            padding: 80px 0;
        }
        
        /* Blog Cards */
        .blog-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 30px;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .blog-card img {
            height: 250px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .blog-card:hover img {
            transform: scale(1.05);
        }
        
        .blog-card-body {
            padding: 25px;
        }
        
        .blog-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .blog-meta i {
            margin-right: 5px;
        }
        
        .blog-title {
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }
        
        .blog-excerpt {
            color: #6c757d;
            margin-bottom: 20px;
        }
        
        .read-more {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .read-more:hover {
            color: var(--secondary-color);
        }
        
        .read-more i {
            margin-left: 5px;
            transition: all 0.3s ease;
        }
        
        .read-more:hover i {
            transform: translateX(5px);
        }
        
        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 100px;
        }
        
        .sidebar-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 30px;
        }
        
        .sidebar-header {
            background: var(--gradient);
            color: white;
            padding: 20px;
            font-weight: 600;
        }
        
        .sidebar-body {
            padding: 20px;
        }
        
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .category-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .category-list li:last-child {
            border-bottom: none;
        }
        
        .category-list a {
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .category-list a:hover {
            color: var(--primary-color);
        }
        
        .category-count {
            background: var(--light-color);
            color: var(--dark-color);
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .recent-post {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .recent-post:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .recent-post-thumb {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            overflow: hidden;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .recent-post-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .recent-post-content {
            flex-grow: 1;
        }
        
        .recent-post-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }
        
        .recent-post-title a {
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .recent-post-title a:hover {
            color: var(--primary-color);
        }
        
        .recent-post-date {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 50px;
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
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-logo {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: white;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
            padding-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .page-title {
                font-size: 2.5rem;
            }
            
            .sidebar {
                position: relative;
                top: 0;
                margin-top: 50px;
            }
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .page-header {
                padding: 100px 0 60px;
            }
            
            .blog-section {
                padding: 60px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><?php echo SITE_NAME; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="blog.php">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php"><i class="bi bi-lock-fill"></i> Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content text-center text-white" data-aos="fade-up">
                <h1 class="page-title">Artikel OSIS</h1>
                <p class="page-subtitle">Informasi terkini seputar kegiatan dan pengumuman OSIS</p>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <!-- Blog Posts -->
                <div class="col-lg-8">
                    <?php
                    // Pagination
                    $limit = 5;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    
                    // Get total posts
                    $total_query = "SELECT COUNT(*) as total FROM posts";
                    $total_result = mysqli_query($conn, $total_query);
                    $total_posts = mysqli_fetch_assoc($total_result)['total'];
                    $total_pages = ceil($total_posts / $limit);
                    
                    // Get posts
                    $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $offset, $limit";
                    $result = mysqli_query($conn, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="blog-card" data-aos="fade-up">';
                            echo '<div class="row g-0">';
                            echo '<div class="col-md-4">';
                            echo '<img src="admin/uploads/' . $row['image'] . '" class="img-fluid rounded-start h-100 object-fit-cover" alt="' . $row['title'] . '">';
                            echo '</div>';
                            echo '<div class="col-md-8">';
                            echo '<div class="blog-card-body">';
                            echo '<div class="blog-meta">';
                            echo '<i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . ' | ';
                            echo '<i class="bi bi-person"></i> ' . $row['author'];
                            echo '</div>';
                            echo '<h5 class="blog-title">' . $row['title'] . '</h5>';
                            echo '<p class="blog-excerpt">' . substr($row['content'], 0, 200) . '...</p>';
                            echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="read-more">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info" data-aos="fade-up">Belum ada artikel tersedia.</div>';
                    }
                    
                    // Pagination
                    if ($total_pages > 1) {
                        echo '<nav aria-label="Page navigation">';
                        echo '<ul class="pagination">';
                        
                        // Previous button
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '"><i class="bi bi-chevron-left"></i></a></li>';
                        }
                        
                        // Page numbers
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                        
                        // Next button
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '"><i class="bi bi-chevron-right"></i></a></li>';
                        }
                        
                        echo '</ul>';
                        echo '</nav>';
                    }
                    ?>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <!-- Categories -->
                        <div class="sidebar-card" data-aos="fade-left">
                            <div class="sidebar-header">
                                <h5 class="mb-0">Kategori</h5>
                            </div>
                            <div class="sidebar-body">
                                <ul class="category-list">
                                    <li>
                                        <a href="#">Pengumuman</a>
                                        <span class="category-count">5</span>
                                    </li>
                                    <li>
                                        <a href="#">Kegiatan</a>
                                        <span class="category-count">8</span>
                                    </li>
                                    <li>
                                        <a href="#">Prestasi</a>
                                        <span class="category-count">3</span>
                                    </li>
                                    <li>
                                        <a href="#">Umum</a>
                                        <span class="category-count">7</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Recent Posts -->
                        <div class="sidebar-card" data-aos="fade-left" data-aos-delay="100">
                            <div class="sidebar-header">
                                <h5 class="mb-0">Artikel Terbaru</h5>
                            </div>
                            <div class="sidebar-body">
                                <?php
                                $query_recent = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
                                $result_recent = mysqli_query($conn, $query_recent);
                                
                                if (mysqli_num_rows($result_recent) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_recent)) {
                                        echo '<div class="recent-post">';
                                        echo '<div class="recent-post-thumb">';
                                        echo '<img src="admin/uploads/' . $row['image'] . '" alt="' . $row['title'] . '">';
                                        echo '</div>';
                                        echo '<div class="recent-post-content">';
                                        echo '<h6 class="recent-post-title"><a href="blog-detail.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h6>';
                                        echo '<div class="recent-post-date"><i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>Belum ada artikel, masih kosong.</p>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <!-- Tags -->
                        <div class="sidebar-card" data-aos="fade-left" data-aos-delay="200">
                            <div class="sidebar-header">
                                <h5 class="mb-0">Tags</h5>
                            </div>
                            <div class="sidebar-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">OSIS</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Prestasi</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Kegiatan</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Pengumuman</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Lomba</a>
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Seminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="footer-logo"><?php echo SITE_NAME; ?></h3>
                    <p>Organisasi Siswa Intra Sekolah SMK Negeri 4 Banjarmasin</p>
                    <div class="social-icons">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSe7yFwJSVqAJTHqwoAi5F9b1rO13Y_HYC-vwROWif11wC1NOg/viewform"><i class="bi-box-arrow-in-down-right"></i></a>
                        <a href="https://www.tiktok.com/@osissmkn4bjm/"><i class="bi bi-tiktok"></i></a>
                        <a href="https://www.instagram.com/osissmkn4bjm/"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/@smknegeri4banjarmasin931"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Menu</h5>
                    <ul class="footer-links">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="about.php">Tentang</a></li>
                        <li><a href="blog.php">Artikel</a></li>
                        <li><a href="events.php">Kegiatan</a></li>
                        <li><a href="contact.php">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Informasi Kontak</h5>
                    <ul class="footer-links">
                        <li><i class="bi bi-geo-alt"></i> Jl. Brigjend H. Hasan Basri, Sungai Miai, Banjarmasin</li>
                        <li><i class="bi bi-telephone"></i> (021) 1234-5678</li>
                        <li><i class="bi bi-envelope"></i> skenpat-people@gmail.com</li>
                        <li><i class="bi bi-clock"></i> Senin - Jumat: 08.00 - 16.00</li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Newsletter</h5>
                    <p>Dapatkan informasi terbaru dari kami</p>
                    <form action="#" method="POST">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email Anda" required>
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved. Developed by <a href="https://github.com/orgs/skenpat/people">skenpat-people</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '10px 0';
                navbar.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.padding = '15px 0';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });
    </script>
</body>
</html>