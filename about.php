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
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(13, 110, 253, 0.6)), url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .section-title {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 15px;
        }
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 80px;
            height: 3px;
            background-color: #0d6efd;
        }
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 100%;
            background-color: #e9ecef;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #0d6efd;
            transform: translateX(-50%);
        }
        .timeline-content {
            position: relative;
            width: 45%;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
        }
        .org-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 30px 0;
        }
        .org-level {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
        }
        .org-box {
            background-color: #0d6efd;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin: 0 10px;
            min-width: 180px;
        }
        .org-box.secondary {
            background-color: #6c757d;
        }
        .org-box.tertiary {
            background-color: #198754;
        }
        @media (max-width: 768px) {
            .timeline:before {
                left: 20px;
            }
            .timeline-item:before {
                left: 20px;
            }
            .timeline-content {
                width: calc(100% - 60px);
                margin-left: 40px !important;
            }
            .org-level {
                flex-direction: column;
                align-items: center;
            }
            .org-box {
                margin-bottom: 15px;
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
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
            <h1 class="display-4 fw-bold">Tentang OSIS</h1>
            <p class="lead">Mengenal lebih dekat Organisasi Siswa Intra Sekolah SMK Negeri 4 Banjarmasin</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-title">Sejarah OSIS</h2>
                    <p>Organisasi Siswa Intra Sekolah (OSIS) SMK Negeri 4 Banjarmasin didirikan pada tahun 1985 sebagai wadah bagi siswa untuk mengembangkan potensi diri dan berkontribusi positif bagi sekolah dan masyarakat. Sejak berdirinya, OSIS telah menjadi bagian integral dari kehidupan sekolah, mengorganisir berbagai kegiatan yang mendukung pengembangan karakter, kreativitas, dan kepemimpinan siswa.</p>
                    <p>OSIS SMK Negeri 4 Banjarmasin terus berkembang seiring dengan perubahan zaman, menyesuaikan program kerjanya dengan kebutuhan siswa dan tantangan global. Dengan semangat "Bersama kita bisa", OSIS berkomitmen untuk mencetak generasi muda yang berprestasi, berkarakter, dan berkontribusi bagi bangsa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">Visi</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Menjadi organisasi siswa yang inovatif, kreatif, dan berprestasi dalam mengembangkan potensi diri serta berkontribusi aktif bagi kemajuan sekolah dan masyarakat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title mb-0">Misi</h3>
                        </div>
                        <div class="card-body">
                            <ul class="card-text">
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
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Struktur Organisasi</h2>
            <p>OSIS SMK Negeri 4 Banjarmasin memiliki struktur organisasi yang jelas dengan pembagian tugas dan tanggung jawab yang merata di antara pengurus untuk memastikan kelancaran program kerja.</p>
            
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
                        <h5>Seksi Kesra</h5>
                        <p>Kesejahteraan Siswa</p>
                    </div>
                    <div class="org-box tertiary">
                        <h5>Seksi PSDM</h5>
                        <p>Pengembangan SDM</p>
                    </div>
                    <div class="org-box tertiary">
                        <h5>Seksi Prestasi</h5>
                        <p>Pendampingan Prestasi</p>
                    </div>
                </div>
                
                <div class="org-level">
                    <div class="org-box tertiary">
                        <h5>Seksi Humas</h5>
                        <p>Hubungan Masyarakat</p>
                    </div>
                    <div class="org-box tertiary">
                        <h5>Seksi Sosial</h5>
                        <p>Kegiatan Sosial</p>
                    </div>
                    <div class="org-box tertiary">
                        <h5>Seksi Seni Budaya</h5>
                        <p>Pengembangan Seni & Budaya</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Perjalanan OSIS</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5>1985</h5>
                        <p>OSIS SMK Negeri 4 Banjarmasin didirikan dengan 15 anggota pendiri.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5>1990</h5>
                        <p>Menyelenggarakan kegiatan OSIS tingkat kota pertama kali.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5>2000</h5>
                        <p>Memperluas struktur organisasi dengan menambah seksi-seksi baru.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5>2010</h5>
                        <p>Meluncurkan website OSIS pertama untuk meningkatkan komunikasi.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5>2020</h5>
                        <p>Beradaptasi dengan pandemi dengan mengadakan kegiatan daring.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h5>2023</h5>
                        <p>Meluncurkan website baru dengan fitur yang lebih lengkap dan modern.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Nilai-Nilai OSIS</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-people-fill fs-1 text-primary"></i>
                            </div>
                            <h5>Kerjasama</h5>
                            <p>Membangun tim yang solid dan saling mendukung untuk mencapai tujuan bersama.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-lightbulb-fill fs-1 text-warning"></i>
                            </div>
                            <h5>Inovasi</h5>
                            <p>Terus berkreativitas dan mencari ide-ide baru untuk kemajuan organisasi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="bi bi-heart-fill fs-1 text-danger"></i>
                            </div>
                            <h5>Integritas</h5>
                            <p>Bertindak jujur, bertanggung jawab, dan berkomitmen pada nilai-nilai luhur.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo SITE_NAME; ?></h5>
                    <p>Organisasi Siswa Intra Sekolah SMK Negeri 4 Banjarmasin</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                    <p>Developed by <a href="https://github.com/orgs/skenpat/people">skenpat-people</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>
</html>