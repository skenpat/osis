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
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
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
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <div class="dark-mode-toggle ms-2"></div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6 hero-content">
                    <h1 class="display-4 fw-bold text-white mb-4">Selamat Datang di OSIS <?php echo SITE_NAME; ?></h1>
                    <p class="lead text-white mb-5">Mewujudkan generasi muda yang berprestasi, berkarakter, dan berkontribusi positif bagi sekolah dan masyarakat.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#about" class="btn btn-light btn-lg">Tentang Kami</a>
                        <a href="#events" class="btn btn-outline-light btn-lg">Kegiatan Terbaru</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-box">
                        <div class="stats-number counter" data-target="50">0</div>
                        <div class="stats-label">Anggota Aktif</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-box">
                        <div class="stats-number counter" data-target="25">0</div>
                        <div class="stats-label">Kegiatan Tahun Ini</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-box">
                        <div class="stats-number counter" data-target="15">0</div>
                        <div class="stats-label">Penghargaan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-box">
                        <div class="stats-number counter" data-target="5">0</div>
                        <div class="stats-label">Tahun Berdiri</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Tentang OSIS</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <div class="col-lg-6 mb-4 animate-on-scroll">
                    <h3 class="fw-bold mb-3">Visi</h3>
                    <p>Menjadi organisasi siswa yang inovatif, kreatif, dan berprestasi dalam mengembangkan potensi diri serta berkontribusi aktif bagi kemajuan sekolah dan masyarakat.</p>
                </div>
                <div class="col-lg-6 mb-4 animate-on-scroll">
                    <h3 class="fw-bold mb-3">Misi</h3>
                    <ul>
                        <li>Meningkatkan kualitas sumber daya manusia melalui berbagai kegiatan pengembangan diri</li>
                        <li>Menjalin kerjasama yang harmonis antar siswa, guru, dan masyarakat</li>
                        <li>Menumbuhkan jiwa kepemimpinan dan kemandirian siswa</li>
                        <li>Menjadi wadah aspirasi dan kreativitas siswa</li>
                    </ul>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="row mt-5">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Program Unggulan</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box animate-on-scroll">
                        <div class="feature-icon">
                            <i class="bi bi-book"></i>
                        </div>
                        <h4>Pendidikan</h4>
                        <p>Program pengembangan akademik dan non-akademik untuk meningkatkan prestasi siswa.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box animate-on-scroll">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>Leadership</h4>
                        <p>Pelatihan kepemimpinan untuk membentuk karakter pemimpin yang tangguh dan bertanggung jawab.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-box animate-on-scroll">
                        <div class="feature-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h4>Sosial</h4>
                        <p>Kegiatan sosial untuk menumbuhkan kepedulian terhadap sesama dan lingkungan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Berita Terbaru</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <?php
                $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-lg-4 mb-4 animate-on-scroll">';
                        echo '<div class="card h-100 shadow-sm">';
                        echo '<img src="admin/uploads/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                        echo '<p class="card-text">' . substr($row['content'], 0, 150) . '...</p>';
                        echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="btn btn-primary">Baca Selengkapnya</a>';
                        echo '</div>';
                        echo '<div class="card-footer text-muted">';
                        echo '<small><i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . '</small>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada berita tersedia.</p></div>';
                }
                ?>
                <div class="col-12 text-center mt-4">
                    <a href="blog.php" class="btn btn-outline-primary">Lihat Semua Berita</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section id="events" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Kegiatan Mendatang</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <?php
                $current_date = date('Y-m-d');
                $query = "SELECT * FROM events WHERE event_date >= '$current_date' ORDER BY event_date ASC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-lg-4 mb-4 animate-on-scroll">';
                        echo '<div class="card h-100 shadow-sm">';
                        echo '<div class="card-header bg-primary text-white">';
                        echo '<h5 class="card-title mb-0">' . $row['title'] . '</h5>';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<p class="card-text">' . substr($row['description'], 0, 150) . '...</p>';
                        echo '</div>';
                        echo '<ul class="list-group list-group-flush">';
                        echo '<li class="list-group-item"><i class="bi bi-calendar3"></i> ' . format_date($row['event_date']) . '</li>';
                        echo '<li class="list-group-item"><i class="bi bi-geo-alt"></i> ' . $row['location'] . '</li>';
                        echo '<li class="list-group-item"><i class="bi bi-clock"></i> ' . $row['time'] . '</li>';
                        echo '</ul>';
                        echo '<div class="card-body">';
                        echo '<a href="event-detail.php?id=' . $row['id'] . '" class="btn btn-primary">Detail Kegiatan</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada kegiatan mendatang.</p></div>';
                }
                ?>
                <div class="col-12 text-center mt-4">
                    <a href="events.php" class="btn btn-outline-primary">Lihat Semua Kegiatan</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Testimoni</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <div class="col-lg-8 mx-auto">
                    <div class="testimonial">
                        <div class="testimonial-content">
                            <p>"Bergabung dengan OSIS telah mengubah hidup saya. Saya belajar banyak tentang kepemimpinan, kerjasama tim, dan bagaimana berkontribusi positif bagi sekolah dan masyarakat."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="assets/img/testimonial1.jpg" alt="Testimonial" class="img-fluid">
                            <div>
                                <h5>Ahmad Rizki</h5>
                                <p>Ketua OSIS 2022/2023</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial" style="display: none;">
                        <div class="testimonial-content">
                            <p>"Program-program yang diadakan OSIS sangat bermanfaat untuk pengembangan diri. Saya menjadi lebih percaya diri dan siap menghadapi tantangan di masa depan."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="assets/img/testimonial2.jpg" alt="Testimonial" class="img-fluid">
                            <div>
                                <h5>Siti Nurhaliza</h5>
                                <p>Anggota OSIS Bidang Pendidikan</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial" style="display: none;">
                        <div class="testimonial-content">
                            <p>"OSIS mengajarkan saya arti tanggung jawab dan dedikasi. Pengalaman ini tidak akan saya lupakan dan akan menjadi bekal berharga di masa depan."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="assets/img/testimonial3.jpg" alt="Testimonial" class="img-fluid">
                            <div>
                                <h5>Budi Santoso</h5>
                                <p>Anggota OSIS Bidang Sosial</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button class="btn btn-sm btn-outline-primary testimonial-prev"><i class="bi bi-chevron-left"></i></button>
                        <button class="btn btn-sm btn-outline-primary testimonial-next"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Galeri Kegiatan</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="gallery-item">
                        <img src="assets/img/gallery1.jpg" alt="Gallery" class="img-fluid">
                        <div class="gallery-overlay">
                            <h4 class="gallery-title">Pelatihan Kepemimpinan</h4>
                            <p class="gallery-category">Leadership</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="gallery-item">
                        <img src="assets/img/gallery2.jpg" alt="Gallery" class="img-fluid">
                        <div class="gallery-overlay">
                            <h4 class="gallery-title">Bakti Sosial</h4>
                            <p class="gallery-category">Sosial</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="gallery-item">
                        <img src="assets/img/gallery3.jpg" alt="Gallery" class="img-fluid">
                        <div class="gallery-overlay">
                            <h4 class="gallery-title">Lomba Cerdas Cermat</h4>
                            <p class="gallery-category">Pendidikan</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mt-2">
                    <a href="gallery.php" class="btn btn-primary">Lihat Semua Foto</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Hubungi Kami</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <div class="col-lg-6 mb-4">
                    <h4 class="mb-3">Kirim Pesan</h4>
                    <form action="contact.php" method="POST" class="contact-form needs-validation" novalidate>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <div class="invalid-feedback">Silakan masukkan nama lengkap Anda.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Silakan masukkan email yang valid.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                            <div class="invalid-feedback">Silakan masukkan subjek pesan.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            <div class="invalid-feedback">Silakan masukkan pesan Anda.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
                <div class="col-lg-6 mb-4">
                    <h4 class="mb-3">Informasi Kontak</h4>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5>Alamat</h5>
                            <p>Jl. Pendidikan No. 123, Jakarta, Indonesia</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-telephone-fill text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5>Telepon</h5>
                            <p>(021) 1234-5678</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-envelope-fill text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5>Email</h5>
                            <p>skenpat-people@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="bi bi-clock-fill text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5>Jam Operasional</h5>
                            <p>Senin - Jumat: 08.00 - 16.00</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5 class="mb-3">Ikuti Kami</h5>
                        <div class="d-flex gap-3">
                            <a href="https://docs.google.com/forms/d/e/1FAIpQLSe7yFwJSVqAJTHqwoAi5F9b1rO13Y_HYC-vwROWif11wC1NOg/viewform" class="text-primary fs-4"><i class="bi-box-arrow-in-down-right"></i></a>
                            <a href="https://www.tiktok.com/@osissmkn4bjm/" class="text-primary fs-4"><i class="bi bi-tiktok"></i></a>
                            <a href="https://www.instagram.com/osissmkn4bjm/" class="text-primary fs-4"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.youtube.com/@smknegeri4banjarmasin931" class="text-primary fs-4"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                    
                    <!-- Map -->
                    <div class="map-container mt-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.8485175545144!2d114.59243501475393!3d-3.319599997522814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de6820e0c3b5c0f%3A0x2de6820e0c3b5c0f!2sSMK%20Negeri%204%20Banjarmasin!5e0!3m2!1sen!2sid!4v1629247654321!5m2!1sen!2sid" allowfullscreen="" loading="lazy"></iframe>
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

    <!-- Back to Top Button -->
    <div class="back-to-top">
        <i class="bi bi-arrow-up"></i>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <h4><?php echo SITE_NAME; ?></h4>
            <button class="mobile-menu-close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="mobile-menu-body">
            <ul class="mobile-menu-nav">
                <li><a href="index.php" class="active">Beranda</a></li>
                <li><a href="about.php">Tentang</a></li>
                <li><a href="blog.php">Berita</a></li>
                <li><a href="events.php">Kegiatan</a></li>
                <li><a href="contact.php">Kontak</a></li>
            </ul>
        </div>
        <div class="mobile-menu-footer">
            <div class="dark-mode-toggle mx-auto"></div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>
</html>