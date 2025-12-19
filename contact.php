<?php require_once 'config.php'; ?>

<?php
// Process contact form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $subject = clean_input($_POST['subject']);
    $message = clean_input($_POST['message']);
    
    // Validate form data
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Semua field harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        // Insert message into database
        $query = "INSERT INTO contacts (name, email, subject, message, created_at) 
                  VALUES ('$name', '$email', '$subject', '$message', NOW())";
        
        if (mysqli_query($conn, $query)) {
            $success = "Pesan Anda telah berhasil dikirim. Kami akan segera merespons.";
        } else {
            $error = "Terjadi kesalahan. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - <?php echo SITE_NAME; ?></title>
    
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
                        <a class="nav-link active" href="contact.php">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php"><i class="bi bi-lock-fill"></i> Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="bg-primary text-white py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Hubungi Kami</h1>
            <p class="lead">Kirim pesan dan pertanyaan Anda kepada kami</p>
        </div>
    </div>

    <!-- Contact Content -->
    <section class="py-5">
        <div class="container">
            <?php if (isset($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="row">
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
                            <p>Jl. Brigjend H. Hasan Basri, Sungai Miai, Kec. Banjarmasin Utara, Kota Banjarmasin, Kalimantan Selatan 70123</p>
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
            
            <!-- Map Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Lokasi Kami</h3>
                    <div class="card shadow-sm">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.2233200878404!2d114.5901172!3d-3.2947944000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de423a0b07eb9cd%3A0xc5fc816bceb7bcf7!2sSekolah%20Menengah%20Kejuruan%20Negeri%204%20Banjarmasin!5e0!3m2!1sid!2sid!4v1766095002965!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>
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