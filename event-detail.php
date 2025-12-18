<?php require_once 'config.php'; ?>

<?php
// Get event ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('events.php');
}

 $event_id = (int)$_GET['id'];

// Get event data
 $query = "SELECT * FROM events WHERE id = $event_id";
 $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    redirect('events.php');
}

 $event = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $event['title']; ?> - <?php echo SITE_NAME; ?></title>
    
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

    <!-- Event Detail Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm animate-on-scroll">
                        <div class="card-header <?php echo (strtotime($event['event_date']) >= strtotime(date('Y-m-d'))) ? 'bg-primary' : 'bg-secondary'; ?> text-white">
                            <h1 class="card-title mb-0"><?php echo $event['title']; ?></h1>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <p><i class="bi bi-calendar3"></i> <strong>Tanggal:</strong> <?php echo format_date($event['event_date']); ?></p>
                                    <p><i class="bi bi-clock"></i> <strong>Waktu:</strong> <?php echo $event['time']; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="bi bi-geo-alt"></i> <strong>Lokasi:</strong> <?php echo $event['location']; ?></p>
                                    <p><i class="bi bi-person"></i> <strong>Penanggung Jawab:</strong> <?php echo $event['organizer']; ?></p>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h4>Deskripsi Kegiatan</h4>
                                <p><?php echo nl2br($event['description']); ?></p>
                            </div>
                            
                            <?php if (!empty($event['requirements'])): ?>
                            <div class="mb-4">
                                <h4>Persyaratan</h4>
                                <p><?php echo nl2br($event['requirements']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($event['contact_info'])): ?>
                            <div class="mb-4">
                                <h4>Informasi Kontak</h4>
                                <p><?php echo nl2br($event['contact_info']); ?></p>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between flex-wrap">
                                <a href="events.php" class="btn btn-outline-primary mb-2 mb-md-0"><i class="bi bi-arrow-left"></i> Kembali ke Kegiatan</a>
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Registration Form -->
                    <?php if (strtotime($event['event_date']) >= strtotime(date('Y-m-d'))): ?>
                    <div class="card shadow-sm mt-4 animate-on-scroll">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Pendaftaran</h4>
                        </div>
                        <div class="card-body">
                            <form action="event-register.php" method="POST">
                                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fullName" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="class" class="form-label">Kelas</label>
                                        <input type="text" class="form-control" id="class" name="class" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan (Opsional)</label>
                                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Comments Section -->
                    <div class="card shadow-sm mt-4 animate-on-scroll">
                        <div class="card-header">
                            <h4 class="mb-0">Komentar</h4>
                        </div>
                        <div class="card-body">
                            <!-- Comment Form -->
                            <form class="mb-4">
                                <div class="mb-3">
                                    <label for="commentName" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="commentName" required>
                                </div>
                                <div class="mb-3">
                                    <label for="commentEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="commentEmail" required>
                                </div>
                                <div class="mb-3">
                                    <label for="commentText" class="form-label">Komentar</label>
                                    <textarea class="form-control" id="commentText" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                            </form>
                            
                            <!-- Comments List -->
                            <div class="comments-list">
                                <div class="comment">
                                    <div class="comment-header">
                                        <img src="assets/img/user1.jpg" alt="User" class="comment-avatar">
                                        <div>
                                            <div class="comment-author">Ahmad Rizki</div>
                                            <div class="comment-date">2 hari yang lalu</div>
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p>Kegiatan ini sangat bermanfaat! Saya sudah mendaftar dan tidak sabar untuk mengikutinya.</p>
                                    </div>
                                    <div class="comment-reply">Balas</div>
                                </div>
                                
                                <div class="comment">
                                    <div class="comment-header">
                                        <img src="assets/img/user2.jpg" alt="User" class="comment-avatar">
                                        <div>
                                            <div class="comment-author">Siti Nurhaliza</div>
                                            <div class="comment-date">1 minggu yang lalu</div>
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p>Apakah kegiatan ini terbuka untuk umum atau hanya untuk siswa tertentu?</p>
                                    </div>
                                    <div class="comment-reply">Balas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <!-- Event Sidebar -->
                    <div class="card shadow-sm mb-4 animate-on-scroll">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Informasi Kegiatan</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h5>Kategori</h5>
                                <span class="badge bg-primary"><?php echo ucfirst($event['category']); ?></span>
                            </div>
                            <div class="mb-3">
                                <h5>Status</h5>
                                <?php if (strtotime($event['event_date']) >= strtotime(date('Y-m-d'))): ?>
                                    <span class="badge bg-success">Akan Datang</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Selesai</span>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <h5>Kuota Peserta</h5>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65/100</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h5>Bagikan</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-link-45deg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upcoming Events -->
                    <div class="card shadow-sm mb-4 animate-on-scroll">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Kegiatan Mendatang</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $current_date = date('Y-m-d');
                            $query = "SELECT * FROM events WHERE event_date >= '$current_date' AND id != $event_id ORDER BY event_date ASC LIMIT 3";
                            $result = mysqli_query($conn, $query);
                            
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="mb-3 pb-3 border-bottom">';
                                    echo '<h6><a href="event-detail.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h6>';
                                    echo '<p class="mb-1"><i class="bi bi-calendar3"></i> ' . format_date($row['event_date']) . '</p>';
                                    echo '<p class="mb-0"><i class="bi bi-geo-alt"></i> ' . $row['location'] . '</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Belum ada kegiatan mendatang.</p>';
                            }
                            ?>
                            <div class="text-center">
                                <a href="events.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Gallery -->
                    <div class="card shadow-sm animate-on-scroll">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Galeri</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <img src="assets/img/event1.jpg" alt="Event" class="img-fluid rounded">
                                </div>
                                <div class="col-6">
                                    <img src="assets/img/event2.jpg" alt="Event" class="img-fluid rounded">
                                </div>
                                <div class="col-6">
                                    <img src="assets/img/event3.jpg" alt="Event" class="img-fluid rounded">
                                </div>
                                <div class="col-6">
                                    <img src="assets/img/event4.jpg" alt="Event" class="img-fluid rounded">
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua Foto</a>
                            </div>
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
                <li><a href="index.php">Beranda</a></li>
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