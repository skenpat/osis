<?php require_once 'config.php'; ?>

<?php
// Get post ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('blog.php');
}

 $post_id = (int)$_GET['id'];

// Get post data
 $query = "SELECT * FROM posts WHERE id = $post_id";
 $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    redirect('blog.php');
}

 $post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?> - <?php echo SITE_NAME; ?></title>
    
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
        
        /* Blog Detail Content */
        .blog-detail-section {
            padding: 120px 0 80px;
        }
        
        .blog-detail-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: none;
            margin-bottom: 40px;
        }
        
        .blog-detail-image {
            height: 400px;
            object-fit: cover;
            width: 100%;
        }
        
        .blog-detail-body {
            padding: 40px;
        }
        
        .blog-detail-title {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 2.5rem;
            color: var(--dark-color);
        }
        
        .blog-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .blog-detail-meta-item {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .blog-detail-meta-item i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .blog-detail-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        
        .blog-detail-content p {
            margin-bottom: 20px;
        }
        
        .blog-detail-content h3 {
            font-weight: 600;
            margin-top: 30px;
            margin-bottom: 15px;
            color: var(--dark-color);
        }
        
        .blog-detail-content ul {
            margin-bottom: 20px;
            padding-left: 20px;
        }
        
        .blog-detail-content li {
            margin-bottom: 10px;
        }
        
        .blog-detail-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: var(--light-color);
        }
        
        .back-to-blog {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .back-to-blog:hover {
            color: var(--secondary-color);
        }
        
        .back-to-blog i {
            margin-right: 8px;
        }
        
        .social-share {
            display: flex;
            gap: 10px;
        }
        
        .social-share a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            color: var(--dark-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .social-share a:hover {
            background: var(--gradient);
            color: white;
            transform: translateY(-3px);
        }
        
        /* Related Posts */
        .related-posts {
            margin-top: 60px;
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 80px;
            height: 3px;
            background: var(--accent-color);
        }
        
        .related-post-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .related-post-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .related-post-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .related-post-body {
            padding: 20px;
        }
        
        .related-post-title {
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        
        .related-post-title a {
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .related-post-title a:hover {
            color: var(--primary-color);
        }
        
        .related-post-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .read-more-btn {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .read-more-btn:hover {
            color: var(--secondary-color);
        }
        
        .read-more-btn i {
            margin-left: 5px;
            transition: all 0.3s ease;
        }
        
        .read-more-btn:hover i {
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
            .blog-detail-title {
                font-size: 2rem;
            }
            
            .sidebar {
                position: relative;
                top: 0;
                margin-top: 50px;
            }
        }
        
        @media (max-width: 768px) {
            .blog-detail-section {
                padding: 100px 0 60px;
            }
            
            .blog-detail-title {
                font-size: 1.75rem;
            }
            
            .blog-detail-body {
                padding: 25px;
            }
            
            .blog-detail-footer {
                flex-direction: column;
                gap: 20px;
                text-align: center;
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
                        <a class="nav-link" href="blog.php">Artikel</a>
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

    <!-- Blog Detail Content -->
    <section class="blog-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-detail-card" data-aos="fade-up">
                        <img src="admin/uploads/<?php echo $post['image']; ?>" class="blog-detail-image" alt="<?php echo $post['title']; ?>">
                        <div class="blog-detail-body">
                            <h1 class="blog-detail-title"><?php echo $post['title']; ?></h1>
                            <div class="blog-detail-meta">
                                <div class="blog-detail-meta-item">
                                    <i class="bi bi-person"></i>
                                    <?php echo $post['author']; ?>
                                </div>
                                <div class="blog-detail-meta-item">
                                    <i class="bi bi-calendar3"></i>
                                    <?php echo format_date($post['created_at']); ?>
                                </div>
                                <div class="blog-detail-meta-item">
                                    <i class="bi bi-folder"></i>
                                    <?php echo $post['category']; ?>
                                </div>
                            </div>
                            <div class="blog-detail-content">
                                <?php echo nl2br($post['content']); ?>
                            </div>
                        </div>
                        <div class="blog-detail-footer">
                            <a href="blog.php" class="back-to-blog">
                                <i class="bi bi-arrow-left"></i> Kembali ke Artikel
                            </a>
                            <div class="social-share">
                                <a href="#" title="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" title="Bagikan ke Twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" title="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                <a href="#" title="Bagikan ke LinkedIn"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Posts -->
                    <div class="related-posts" data-aos="fade-up">
                        <h3 class="section-title">Artikel Terkait</h3>
                        <div class="row">
                            <?php
                            $query_related = "SELECT * FROM posts WHERE id != $post_id AND category = '" . $post['category'] . "' ORDER BY created_at DESC LIMIT 3";
                            $result_related = mysqli_query($conn, $query_related);
                            
                            if (mysqli_num_rows($result_related) > 0) {
                                while ($row = mysqli_fetch_assoc($result_related)) {
                                    echo '<div class="col-md-4 mb-4">';
                                    echo '<div class="related-post-card">';
                                    echo '<img src="admin/uploads/' . $row['image'] . '" class="related-post-image" alt="' . $row['title'] . '">';
                                    echo '<div class="related-post-body">';
                                    echo '<h5 class="related-post-title"><a href="blog-detail.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h5>';
                                    echo '<div class="related-post-meta">' . format_date($row['created_at']) . '</div>';
                                    echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="read-more-btn">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                // If no related posts in same category, show recent posts
                                $query_recent = "SELECT * FROM posts WHERE id != $post_id ORDER BY created_at DESC LIMIT 3";
                                $result_recent = mysqli_query($conn, $query_recent);
                                
                                if (mysqli_num_rows($result_recent) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_recent)) {
                                        echo '<div class="col-md-4 mb-4">';
                                        echo '<div class="related-post-card">';
                                        echo '<img src="admin/uploads/' . $row['image'] . '" class="related-post-image" alt="' . $row['title'] . '">';
                                        echo '<div class="related-post-body">';
                                        echo '<h5 class="related-post-title"><a href="blog-detail.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h5>';
                                        echo '<div class="related-post-meta">' . format_date($row['created_at']) . '</div>';
                                        echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="read-more-btn">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
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
                                $query_recent = "SELECT * FROM posts WHERE id != $post_id ORDER BY created_at DESC LIMIT 5";
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