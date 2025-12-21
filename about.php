<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - <?php echo SITE_NAME; ?></title>
    
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
        
        /* Hero Section */
        .hero-section {
            background: var(--gradient);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://ik.imagekit.io/fles/fotbar2025.jpg?updatedAt=1766187218901') center/cover;
            opacity: 0.15;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-weight: 800;
            margin-bottom: 1.5rem;
            font-size: 3.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Section Styling */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
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
        
        .section-subtitle {
            color: #6c757d;
            margin-bottom: 3rem;
        }
        
        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .feature-icon i {
            font-size: 30px;
            color: white;
        }
        
        /* Vision Mission Cards */
        .vm-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .vm-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .vm-header {
            padding: 20px;
            color: white;
            font-weight: 600;
        }
        
        .vm-header.vision {
            background: var(--gradient);
        }
        
        .vm-header.mission {
            background: linear-gradient(135deg, #198754, #20c997);
        }
        
        .vm-body {
            padding: 30px;
        }
        
        .vm-body ul {
            padding-left: 20px;
        }
        
        .vm-body li {
            margin-bottom: 10px;
        }
        
        /* Organizational Structure */
        .org-chart {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .org-level {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .org-box {
            background: var(--gradient);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            min-width: 180px;
            transition: all 0.3s ease;
        }
        
        .org-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .org-box.secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
        }
        
        .org-box.tertiary {
            background: linear-gradient(135deg, #198754, #20c997);
        }
        
        .org-box h5 {
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .org-box p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 100%;
            background: #e9ecef;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--accent-color);
            transform: translateX(-50%);
        }
        
        .timeline-content {
            position: relative;
            width: 45%;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
        }
        
        .timeline-year {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        /* Values Section */
        .value-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .value-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .value-icon i {
            font-size: 40px;
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
            .hero-title {
                font-size: 2.5rem;
            }
            
            .org-level {
                flex-direction: column;
                align-items: center;
            }
            
            .org-box {
                width: 80%;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-section {
                padding: 100px 0 60px;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .timeline::before {
                left: 20px;
            }
            
            .timeline-item::before {
                left: 20px;
            }
            
            .timeline-content {
                width: calc(100% - 60px);
                margin-left: 40px !important;
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
                        <a class="nav-link active" href="about.php">Tentang</a>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content text-center text-white" data-aos="fade-up">
                <h1 class="hero-title">Tentang OSIS</h1>
                <p class="hero-subtitle">Mengenal lebih dekat Organisasi Siswa Intra Sekolah SMK Negeri 4 Banjarmasin</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up">
                    <h2 class="section-title">Sejarah OSIS</h2>
                    <p class="section-subtitle">Perjalanan panjang OSIS SMK Negeri 4 Banjarmasin dalam mengembangkan potensi siswa</p>
                    <p>Organisasi Siswa Intra Sekolah (OSIS) SMK Negeri 4 Banjarmasin didirikan pada tahun 1985 sebagai wadah bagi siswa untuk mengembangkan potensi diri dan berkontribusi positif bagi sekolah dan masyarakat. Sejak berdirinya, OSIS telah menjadi bagian integral dari kehidupan sekolah, mengorganisir berbagai kegiatan yang mendukung pengembangan karakter, kreativitas, dan kepemimpinan siswa.</p>
                    <p>OSIS SMK Negeri 4 Banjarmasin terus berkembang seiring dengan perubahan zaman, menyesuaikan program kerjanya dengan kebutuhan siswa dan tantangan global. Dengan semangat "Bersama kita bisa", OSIS berkomitmen untuk mencetak generasi muda yang berprestasi, berkarakter, dan berkontribusi bagi bangsa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Visi & Misi</h2>
                    <p class="section-subtitle">Arah dan tujuan OSIS SMK Negeri 4 Banjarmasin</p>
                </div>
                <div class="col-lg-6 mb-4" data-aos="fade-right">
                    <div class="vm-card">
                        <div class="vm-header vision">
                            <h3 class="mb-0">Visi</h3>
                        </div>
                        <div class="vm-body">
                            <p>Menjadi organisasi siswa yang inovatif, kreatif, dan berprestasi dalam mengembangkan potensi diri serta berkontribusi aktif bagi kemajuan sekolah dan masyarakat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4" data-aos="fade-left">
                    <div class="vm-card">
                        <div class="vm-header mission">
                            <h3 class="mb-0">Misi</h3>
                        </div>
                        <div class="vm-body">
                            <ul>
                                <li>Meningkatkan kualitas sumber daya manusia melalui berbagai kegiatan pengembangan diri</li>
                                <li>Menjalin kerjasama yang harmonis antar siswa, guru, dan masyarakat</li>
                                <li>Menumbuhkan jiwa kepemimpinan dan kemandirian siswa</li>
                                <li>Menjadi wadah aspirasi dan kreativitas siswa</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Organizational Structure Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Struktur Organisasi</h2>
                    <p class="section-subtitle">Susunan pengurus OSIS SMK Negeri 4 Banjarmasin</p>
                </div>
                <div class="col-lg-12" data-aos="fade-up">
                    <div class="org-chart">
                        <div class="org-level">
                            <div class="org-box">
                                <h5>Ketua OSIS</h5>
                                <p>Pimpinan tertinggi OSIS</p>
                            </div>
                        </div>
                        
                        <div class="org-level">
                            <div class="org-box secondary">
                                <h5>Wakil Ketua</h5>
                                <p>Membantu tugas Ketua</p>
                            </div>
                        </div>
                        
                        <div class="org-level">
                            <div class="org-box secondary">
                                <h5>Sekretaris</h5>
                                <p>Administrasi & Dokumentasi</p>
                            </div>
                            <div class="org-box secondary">
                                <h5>Bendahara</h5>
                                <p>Keuangan & Perencanaan</p>
                            </div>
                        </div>
                        
                        <div class="org-level">
                            <div class="org-box tertiary">
                                <h5>Wirausaha</h5>
                                <p>Sektor Bidang</p>
                            </div>
                            <div class="org-box tertiary">
                                <h5>Lingkungan Hidup</h5>
                                <p>Sektor Bidang</p>
                            </div>
                            <div class="org-box tertiary">
                                <h5>Hubungan Masyarakat</h5>
                                <p>Sektor Bidang</p>
                            </div>
                        </div>
                        
                        <div class="org-level">
                            <div class="org-box tertiary">
                                <h5>Kepemimpinan</h5>
                                <p>Sektor Bidang</p>
                            </div>
                            <div class="org-box tertiary">
                                <h5>Olahraga</h5>
                                <p>Sektor Bidang</p>
                            </div>
                            <div class="org-box tertiary">
                                <h5>Keagamaan</h5>
                                <p>Sektor Bidang</p>
                            </div>
                            <div class="org-box tertiary">
                                <h5>Bela Negara</h5>
                                <p>Sektor Bidang</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Perjalanan OSIS</h2>
                    <p class="section-subtitle">Momen-momen penting dalam sejarah OSIS SMK Negeri 4 Banjarmasin</p>
                </div>
                <div class="col-lg-12" data-aos="fade-up">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-year">1957</div>
                                <h5>OSIS SMK Negeri 4 Banjarmasin Didirikan</h5>
                                <p>Awal mula berdirinya OSIS sebagai wadah bagi siswa untuk mengembangkan potensi diri.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-year">2017</div>
                                <h5>Akun Instagram OSIS SMKN 4 Banjarmasin Dibuat</h5>
                                <p>Memperluas jangkauan informasi melalui media sosial Instagram.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-year">2023</div>
                                <h5>Akun TikTok OSIS SMKN 4 Banjarmasin Dibuat</h5>
                                <p>Mengikuti perkembangan tren media sosial untuk lebih dekat dengan siswa.</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-year">2025</div>
                                <h5>Website Official OSIS SMKN 4 Banjarmasin Diluncurkan</h5>
                                <p>Platform digital resmi untuk informasi kegiatan dan prestasi OSIS.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Nilai-Nilai OSIS</h2>
                    <p class="section-subtitle">Prinsip yang menjadi landasan setiap kegiatan OSIS</p>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4>Kerjasama</h4>
                        <p>Membangun tim yang solid dan saling mendukung untuk mencapai tujuan bersama.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-lightbulb-fill"></i>
                        </div>
                        <h4>Inovasi</h4>
                        <p>Terus berkreativitas dan mencari ide-ide baru untuk kemajuan organisasi.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h4>Integritas</h4>
                        <p>Bertindak jujur, bertanggung jawab, dan menjunjung tinggi nilai-nilai luhur.</p>
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