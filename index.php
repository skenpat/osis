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
                        <a class="nav-link" href="admin/login.php"><i class="bi bi-lock-fill"></i> Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4">Selamat Datang di OSIS <?php echo SITE_NAME; ?></h1>
                    <p class="lead text-white mb-5">Mewujudkan generasi muda yang berprestasi, berkarakter, dan berkontribusi positif bagi sekolah dan masyarakat.</p>
                    <div class="d-flex gap-3">
                        <a href="#about" class="btn btn-light btn-lg">Tentang Kami</a>
                        <a href="#events" class="btn btn-outline-light btn-lg">Kegiatan Terbaru</a>
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
                <div class="col-lg-6 mb-4">
                    <h3 class="fw-bold mb-3">Visi</h3>
                    <p>Menjadi organisasi siswa yang inovatif, kreatif, dan berprestasi dalam mengembangkan potensi diri serta berkontribusi aktif bagi kemajuan sekolah dan masyarakat.</p>
                </div>
                <div class="col-lg-6 mb-4">
                    <h3 class="fw-bold mb-3">Misi</h3>
                    <ul>
                        <li>Meningkatkan kualitas sumber daya manusia melalui berbagai kegiatan pengembangan diri</li>
                        <li>Menjalin kerjasama yang harmonis antar siswa, guru, dan masyarakat</li>
                        <li>Menumbuhkan jiwa kepemimpinan dan kemandirian siswa</li>
                        <li>Menjadi wadah aspirasi dan kreativitas siswa</li>
                    </ul>
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
                        echo '<div class="col-lg-4 mb-4">';
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
                        echo '<div class="col-lg-4 mb-4">';
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
                    <form action="contact.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
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