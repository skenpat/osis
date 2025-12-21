<?php require_once 'config.php'; ?>
<?php require_once 'functions.php'; ?>

<!DOCTYPE html>
<html lang="id" data-theme="<?php echo isset($_COOKIE['theme_mode']) ? $_COOKIE['theme_mode'] : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - <?php echo SITE_NAME; ?></title>
    <meta name="description" content="Pertanyaan yang sering diajukan tentang OSIS SMK Negeri 4 Banjarmasin">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Theme Toggle CSS -->
    <link href="assets/css/theme-toggle.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        [data-theme="dark"] {
            --dark-color: #f8f9fa;
            --light-color: #2b2d42;
            --card-bg: #343a40;
            --text-color: #e9ecef;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        
        /* Page Header */
        .page-header {
            background: var(--gradient);
            padding: 120px 0 80px;
            color: white;
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
            background: url('https://ik.imagekit.io/fles/ketos_reno.jpg?updatedAt=1766154448985') center/cover;
            opacity: 0.15;
            z-index: 0;
        }
        
        .page-header-content {
            position: relative;
            z-index: 1;
        }
        
        .page-title {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: rgba(255, 255, 255, 0.7);
        }
        
        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            color: white;
        }
        
        /* FAQ Section */
        .faq-section {
            padding: 80px 0;
        }
        
        /* Search Box */
        .search-box {
            max-width: 600px;
            margin: 0 auto 50px;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        [data-theme="dark"] .search-input {
            background: var(--card-bg);
            border-color: #495057;
            color: var(--text-color);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .search-button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-button:hover {
            background: var(--secondary-color);
        }
        
        /* FAQ Categories */
        .faq-categories {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .category-btn {
            background: white;
            border: 1px solid #e9ecef;
            padding: 10px 25px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        [data-theme="dark"] .category-btn {
            background: var(--card-bg);
            border-color: #495057;
            color: var(--text-color);
        }
        
        .category-btn:hover,
        .category-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        /* FAQ Accordion */
        .faq-accordion {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 10px !important;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        [data-theme="dark"] .accordion-item {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .accordion-button {
            background: white;
            color: var(--dark-color);
            font-weight: 600;
            box-shadow: none;
            padding: 20px;
        }
        
        [data-theme="dark"] .accordion-button {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .accordion-button:not(.collapsed) {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .accordion-button:focus {
            box-shadow: none;
        }
        
        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234361ee'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }
        
        .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234361ee'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }
        
        .accordion-body {
            padding: 0 20px 20px;
        }
        
        /* No Results */
        .no-results {
            text-align: center;
            padding: 50px 0;
            display: none;
        }
        
        .no-results i {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 20px;
        }
        
        [data-theme="dark"] .no-results i {
            color: #6c757d;
        }
        
        /* Contact Section */
        .contact-section {
            background: var(--gradient);
            padding: 60px 0;
            color: white;
            text-align: center;
        }
        
        .contact-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .contact-subtitle {
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-contact {
            background: white;
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-contact:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        [data-theme="dark"] .navbar {
            background: rgba(52, 58, 64, 0.95);
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
        
        /* Theme Toggle Button */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .theme-toggle:hover {
            transform: rotate(180deg);
        }
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }
        
        [data-theme="dark"] footer {
            background: #212529;
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
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .faq-categories {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .category-btn {
                white-space: nowrap;
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
                        <a class="nav-link" href="gallery.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php"><i class="bi bi-lock-fill"></i> Admin</a>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link theme-toggle" id="theme-toggle">
                            <i class="bi bi-moon-fill" id="theme-icon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                        <li class="breadcrumb-item active">FAQ</li>
                    </ol>
                </nav>
                <h1 class="page-title">Pertanyaan yang Sering Diajukan</h1>
                <p>Temukan jawaban untuk pertanyaan yang sering diajukan tentang OSIS</p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <!-- Search Box -->
            <div class="search-box" data-aos="fade-up">
                <input type="text" class="search-input" id="faq-search" placeholder="Cari pertanyaan...">
                <button class="search-button" id="search-btn">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            
            <!-- FAQ Categories -->
            <div class="faq-categories" data-aos="fade-up" data-aos-delay="100">
                <button class="category-btn active" data-category="all">Semua</button>
                <button class="category-btn" data-category="umum">Umum</button>
                <button class="category-btn" data-category="kegiatan">Kegiatan</button>
                <button class="category-btn" data-category="keanggotaan">Keanggotaan</button>
                <button class="category-btn" data-category="prestasi">Prestasi</button>
            </div>
            
            <!-- FAQ Accordion -->
            <div class="faq-accordion" data-aos="fade-up" data-aos-delay="200">
                <div class="accordion" id="faqAccordion">
                    <?php
                    $faqs = get_faqs($conn);
                    
                    if (count($faqs) > 0):
                        $count = 0;
                        foreach ($faqs as $faq):
                            $count++;
                    ?>
                    <div class="accordion-item faq-item" data-category="<?php echo $faq['category']; ?>">
                        <h2 class="accordion-header" id="heading<?php echo $count; ?>">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $count; ?>"
                                <?php echo $count > 1 ? 'collapsed' : ''; ?>>
                                <?php echo $faq['question']; ?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $count; ?>" class="accordion-collapse collapse <?php echo $count == 1 ? 'show' : ''; ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <?php echo $faq['answer']; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    else:
                    ?>
                    <div class="text-center py-5">
                        <p>Belum ada FAQ tersedia.</p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- No Results Message -->
                <div class="no-results" id="no-results">
                    <i class="bi bi-search"></i>
                    <h4>Tidak ada hasil yang ditemukan</h4>
                    <p>Coba gunakan kata kunci yang berbeda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up">
                    <h2 class="contact-title">Masih Punya Pertanyaan?</h2>
                    <p class="contact-subtitle">Jika Anda tidak menemukan jawaban yang Anda cari, jangan ragu untuk menghubungi kami.</p>
                    <a href="contact.php" class="btn btn-contact">Hubungi Kami</a>
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
                        <li><a href="gallery.php">Galeri</a></li>
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
                    <form action="subscribe.php" method="POST">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
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
        
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;
        
        // Check for saved theme preference or default to light
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);
        
        themeToggle.addEventListener('click', function() {
            const theme = html.getAttribute('data-theme');
            const newTheme = theme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            document.cookie = `theme_mode=${newTheme}; path=/; max-age=31536000`; // 1 year
            updateThemeIcon(newTheme);
        });
        
        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.classList.remove('bi-moon-fill');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-fill');
            }
        }
        
        // FAQ Search
        const searchInput = document.getElementById('faq-search');
        const searchBtn = document.getElementById('search-btn');
        const faqItems = document.querySelectorAll('.faq-item');
        const noResults = document.getElementById('no-results');
        const accordion = document.getElementById('faqAccordion');
        
        function searchFAQs() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let hasResults = false;
            
            faqItems.forEach(item => {
                const question = item.querySelector('.accordion-button').textContent.toLowerCase();
                const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
                
                if (searchTerm === '' || question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (hasResults) {
                accordion.style.display = 'block';
                noResults.style.display = 'none';
            } else {
                accordion.style.display = 'none';
                noResults.style.display = 'block';
            }
        }
        
        searchBtn.addEventListener('click', searchFAQs);
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                searchFAQs();
            }
        });
        
        // FAQ Categories Filter
        const categoryButtons = document.querySelectorAll('.category-btn');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Update active button
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter FAQ items
                const category = this.getAttribute('data-category');
                let hasResults = false;
                
                faqItems.forEach(item => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                        hasResults = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                if (hasResults) {
                    accordion.style.display = 'block';
                    noResults.style.display = 'none';
                } else {
                    accordion.style.display = 'none';
                    noResults.style.display = 'block';
                }
                
                // Clear search when changing category
                searchInput.value = '';
            });
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