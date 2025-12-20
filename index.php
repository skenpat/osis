<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Organisasi Siswa Intra Sekolah</title>
    
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
            background: url('/img/hero-bg.jpg') center/cover;
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
        
        .hero-buttons .btn {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            margin-right: 15px;
            transition: all 0.3s ease;
        }
        
        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
        }
        
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-hero-outline {
            border: 2px solid white;
            color: white;
        }
        
        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-color);
        }
        
        .hero-image {
            position: relative;
            z-index: 1;
        }
        
        .hero-image img {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            max-width: 100%;
            height: auto;
        }
        
        /* Floating Animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        /* Section Styling */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        
        .section-subtitle {
            color: #6c757d;
            margin-bottom: 3rem;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--accent-color);
            margin: 15px 0;
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
        
        /* News Cards */
        .news-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .news-card img {
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .news-card:hover img {
            transform: scale(1.05);
        }
        
        .news-card-body {
            padding: 20px;
        }
        
        .news-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        /* Event Cards */
        .event-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .event-date {
            background: var(--gradient);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 700;
        }
        
        .event-date .day {
            font-size: 2rem;
            line-height: 1;
        }
        
        .event-date .month {
            font-size: 0.9rem;
        }
        
        .event-body {
            padding: 20px;
        }
        
        .event-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .event-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .event-meta i {
            margin-right: 5px;
        }
        
        /* Achievement Section */
        .achievement-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .achievement-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .achievement-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .achievement-icon i {
            font-size: 40px;
            color: white;
        }
        
        .achievement-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        /* Testimonial Section */
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            color: #6c757d;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .testimonial-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .testimonial-author h5 {
            margin: 0;
            font-weight: 600;
        }
        
        .testimonial-author p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* CTA Section */
        .cta-section {
            background: var(--gradient);
            padding: 80px 0;
            color: white;
            text-align: center;
        }
        
        .cta-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .cta-subtitle {
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-cta {
            background: white;
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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
            
            .hero-image {
                margin-top: 50px;
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
                        <a class="nav-link active" href="index.php">Beranda</a>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content" data-aos="fade-up">
                    <h1 class="hero-title text-white">Selamat Datang di <?php echo SITE_NAME; ?></h1>
                    <p class="hero-subtitle text-white">Mewujudkan generasi muda yang berprestasi, berkarakter, dan berkontribusi positif bagi sekolah dan masyarakat.</p>
                    <div class="hero-buttons">
                        <a href="#about" class="btn btn-hero-primary">Tentang Kami</a>
                        <a href="#events" class="btn btn-hero-outline">Kegiatan Terbaru</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="OSIS Activities" class="floating">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Tentang OSIS</h2>
                    <p class="section-subtitle">Mengenal lebih dekat visi, misi, dan program kerja kami</p>
                </div>
                <div class="col-lg-6 mb-4" data-aos="fade-right">
                    <h3 class="fw-bold mb-3">Visi</h3>
                    <p>Menjadi organisasi siswa yang inovatif, kreatif, dan berprestasi dalam mengembangkan potensi diri serta berkontribusi aktif bagi kemajuan sekolah dan masyarakat.</p>
                </div>
                <div class="col-lg-6 mb-4" data-aos="fade-left">
                    <h3 class="fw-bold mb-3">Misi</h3>
                    <ul>
                        <li>Meningkatkan kualitas sumber daya manusia melalui berbagai kegiatan pengembangan diri</li>
                        <li>Menjalin kerjasama yang harmonis antar siswa, guru, dan masyarakat</li>
                        <li>Menumbuhkan jiwa kepemimpinan dan kemandirian siswa</li>
                        <li>Menjadi wadah aspirasi dan kreativitas siswa</li>
                    </ul>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4>Kerjasama</h4>
                        <p>Membangun tim yang solid dan saling mendukung untuk mencapai tujuan bersama.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightbulb-fill"></i>
                        </div>
                        <h4>Inovasi</h4>
                        <p>Terus berkreativitas dan mencari ide-ide baru untuk kemajuan organisasi.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h4>Integritas</h4>
                        <p>Bertindak jujur, bertanggung jawab, dan menjunjung tinggi nilai-nilai luhur.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Artikel Terbaru</h2>
                    <p class="section-subtitle">Informasi terkini seputar kegiatan dan pengumuman OSIS</p>
                </div>
                <?php
                $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">';
                        echo '<div class="news-card">';
                        echo '<img src="admin/uploads/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">';
                        echo '<div class="news-card-body">';
                        echo '<div class="news-meta"><i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . '</div>';
                        echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                        echo '<p class="card-text">' . substr($row['content'], 0, 150) . '...</p>';
                        echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="btn btn-primary">Baca Selengkapnya</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada artikel tersedia.</p></div>';
                }
                ?>
                <div class="col-12 text-center mt-4" data-aos="fade-up">
                    <a href="blog.php" class="btn btn-outline-primary">Lihat Semua Artikel</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section id="events" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Kegiatan Mendatang</h2>
                    <p class="section-subtitle">Jangan lewatkan kegiatan-kegiatan menarik dari OSIS</p>
                </div>
                <?php
                $current_date = date('Y-m-d');
                $query = "SELECT * FROM events WHERE event_date >= '$current_date' ORDER BY event_date ASC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $event_date = strtotime($row['event_date']);
                        $day = date('d', $event_date);
                        $month = date('M', $event_date);
                        
                        echo '<div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">';
                        echo '<div class="event-card">';
                        echo '<div class="event-date">';
                        echo '<div class="day">' . $day . '</div>';
                        echo '<div class="month">' . $month . '</div>';
                        echo '</div>';
                        echo '<div class="event-body">';
                        echo '<h5 class="event-title">' . $row['title'] . '</h5>';
                        echo '<div class="event-meta">';
                        echo '<div><i class="bi bi-geo-alt"></i> ' . $row['location'] . '</div>';
                        echo '<div><i class="bi bi-clock"></i> ' . $row['time'] . '</div>';
                        echo '</div>';
                        echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<a href="event-detail.php?id=' . $row['id'] . '" class="btn btn-primary">Detail Kegiatan</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada kegiatan mendatang.</p></div>';
                }
                ?>
                <div class="col-12 text-center mt-4" data-aos="fade-up">
                    <a href="events.php" class="btn btn-outline-primary">Lihat Semua Kegiatan</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Prestasi Kami</h2>
                    <p class="section-subtitle">Pencapaian yang telah diraih oleh OSIS SMK Negeri 4 Banjarmasin</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <div class="achievement-number">15+</div>
                        <p>Prestasi Tingkat Kota</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="achievement-number">8+</div>
                        <p>Prestasi Tingkat Provinsi</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="achievement-number">3+</div>
                        <p>Prestasi Tingkat Nasional</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="achievement-number">200+</div>
                        <p>Anggota Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Testimoni</h2>
                    <p class="section-subtitle">Apa kata mereka tentang OSIS SMK Negeri 4 Banjarmasin</p>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Bergabung dengan OSIS telah membantu saya mengembangkan kemampuan kepemimpinan dan meningkatkan rasa percaya diri. Saya belajar banyak tentang kerjasama tim dan tanggung jawab."
                        </div>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/seed/person1/100/100.jpg" alt="Testimonial">
                            <div>
                                <h5>Ahmad Rizki</h5>
                                <p>Ketua OSIS 2022/2023</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "OSIS memberikan saya kesempatan untuk mengeksplorasi bakat dan minat saya. Melalui berbagai kegiatan, saya bisa mengembangkan kreativitas dan inovasi."
                        </div>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/seed/person2/100/100.jpg" alt="Testimonial">
                            <div>
                                <h5>Siti Nurhaliza</h5>
                                <p>Sekretaris OSIS 2022/2023</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Melalui OSIS, saya belajar tentang pentingnya kontribusi bagi sekolah dan masyarakat. Ini adalah pengalaman yang sangat berharga untuk masa depan saya."
                        </div>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/seed/person3/100/100.jpg" alt="Testimonial">
                            <div>
                                <h5>Budi Santoso</h5>
                                <p>Anggota OSIS 2022/2023</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up">
                    <h2 class="cta-title">Bergabunglah Bersama Kami</h2>
                    <p class="cta-subtitle">Mari wujudkan generasi muda yang berprestasi, berkarakter, dan berkontribusi positif bagi sekolah dan masyarakat.</p>
                    <a href="contact.php" class="btn btn-cta">Hubungi Kami</a>
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