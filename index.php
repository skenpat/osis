<?php
// Tampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);
// index.php - Landing Page Utama
include 'config.php';

// Ambil data terbaru
 $query_posts = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3";
 $result_posts = $conn->query($query_posts);

 $query_events = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3";
 $result_events = $conn->query($query_events);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSIS SMK Negeri 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 40px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--secondary-color);
        }
        
        .event-card {
            border-left: 4px solid var(--secondary-color);
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .footer {
            background: var(--primary-color);
            color: white;
            padding: 50px 0 20px;
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-mortarboard-fill text-primary"></i> OSIS SMKN4BJM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kegiatan">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#berita">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white px-3" href="admin/login.php">
                            <i class="bi bi-box-arrow-in-right"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Selamat Datang di OSIS SMK Negeri 4 Banjarmasin</h1>
                    <p class="lead mb-4">Organisasi Siswa Intra Sekolah yang berdedikasi untuk mengembangkan potensi siswa dan membangun karakter kepemimpinan.</p>
                    <div class="d-flex gap-3">
                        <a href="#tentang" class="btn btn-light btn-lg">Pelajari Lebih Lanjut</a>
                        <a href="#kegiatan" class="btn btn-outline-light btn-lg">Lihat Kegiatan</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://picsum.photos/seed/osis-hero/600/400" alt="OSIS" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Tentang OSIS</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h3>Visi</h3>
                    <p>Menjadi organisasi siswa yang unggul, kreatif, dan inovatif dalam mengembangkan potensi diri serta berkontribusi positif bagi sekolah dan masyarakat.</p>
                </div>
                <div class="col-lg-6 mb-4">
                    <h3>Misi</h3>
                    <ul>
                        <li>Meningkatkan kualitas siswa melalui berbagai kegiatan positif</li>
                        <li>Menumbuhkan jiwa kepemimpinan dan kerjasama</li>
                        <li>Membangun karakter siswa yang berakhlak mulia</li>
                        <li>Menjadi jembatan antara siswa dengan pihak sekolah</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Kegiatan Section -->
    <section id="kegiatan" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title">Kegiatan Mendatang</h2>
            <div class="row">
                <?php if ($result_events->num_rows > 0): ?>
                    <?php while ($event = $result_events->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card event-card card-hover h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span class="badge bg-primary"><?php echo date('d M Y', strtotime($event['event_date'])); ?></span>
                                        <i class="bi bi-calendar-event text-primary"></i>
                                    </div>
                                    <h5 class="card-title"><?php echo $event['title']; ?></h5>
                                    <p class="card-text"><?php echo substr($event['description'], 0, 100) . '...'; ?></p>
                                    <small class="text-muted"><i class="bi bi-geo-alt"></i> <?php echo $event['location']; ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada kegiatan terjadwal.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-center mt-4">
                <a href="events.php" class="btn btn-primary">Lihat Semua Kegiatan</a>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section id="berita" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Berita Terbaru</h2>
            <div class="row">
                <?php if ($result_posts->num_rows > 0): ?>
                    <?php while ($post = $result_posts->fetch_assoc()): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card card-hover h-100">
                                <?php if ($post['image']): ?>
                                    <img src="admin/uploads/<?php echo $post['image']; ?>" class="card-img-top" alt="<?php echo $post['title']; ?>">
                                <?php else: ?>
                                    <img src="https://picsum.photos/seed/<?php echo $post['id']; ?>/400/250" class="card-img-top" alt="<?php echo $post['title']; ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <span class="badge bg-secondary mb-2"><?php echo $post['category']; ?></span>
                                    <h5 class="card-title"><?php echo $post['title']; ?></h5>
                                    <p class="card-text"><?php echo substr($post['content'], 0, 100) . '...'; ?></p>
                                    <small class="text-muted"><i class="bi bi-person"></i> <?php echo $post['author']; ?> | <i class="bi bi-clock"></i> <?php echo date('d M Y', strtotime($post['created_at'])); ?></small>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="blog-detail.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada berita terbaru.</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-center mt-4">
                <a href="blog.php" class="btn btn-primary">Lihat Semua Berita</a>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title">Hubungi Kami</h2>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Informasi Kontak</h5>
                            <p class="card-text">
                                <i class="bi bi-geo-alt-fill text-primary"></i> Jl. Pendidikan No. 123, Jakarta<br>
                                <i class="bi bi-telephone-fill text-primary"></i> (021) 1234-5678<br>
                                <i class="bi bi-envelope-fill text-primary"></i> osis@smkn1.sch.id<br>
                                <i class="bi bi-instagram text-primary"></i> @osissmkn1
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Kirim Pesan</h5>
                            <form action="contact.php" method="POST">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Anda" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email Anda" required>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" name="message" rows="4" placeholder="Pesan Anda" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>OSIS SMK Negeri 4 Banjarmasin</h5>
                    <p>Organisasi Siswa Intra Sekolah yang berdedikasi untuk kemajuan siswa dan sekolah.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Link Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="#beranda" class="text-white-50">Beranda</a></li>
                        <li><a href="#tentang" class="text-white-50">Tentang</a></li>
                        <li><a href="#kegiatan" class="text-white-50">Kegiatan</a></li>
                        <li><a href="#berita" class="text-white-50">Berita</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Ikuti Kami</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-white-50">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> OSIS SMK Negeri 4 Banjarmasin. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>
