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
                        <a class="nav-link" href="admin/login.php"><i class="bi bi-lock-fill"></i> Admin</a>
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
                    <div class="card shadow-sm">
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
                            
                            <div class="d-flex justify-content-between">
                                <a href="events.php" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Kembali ke Kegiatan</a>
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Gallery -->
                    <?php if (!empty($event['image'])): ?>
                    <div class="mt-5">
                        <h3 class="mb-4">Dokumentasi Kegiatan</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <img src="admin/uploads/<?php echo $event['image']; ?>" class="img-fluid rounded shadow-sm" alt="<?php echo $event['title']; ?>">
                            </div>
                            <!-- Placeholder for additional images -->
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <span class="text-muted">Foto 2</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <span class="text-muted">Foto 3</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <span class="text-muted">Foto 4</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <span class="text-muted">Foto 5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Event Status -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Status Kegiatan</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $event_date = strtotime($event['event_date']);
                            $current_date = strtotime(date('Y-m-d'));
                            
                            if ($event_date > $current_date) {
                                $days_left = ceil(($event_date - $current_date) / (60 * 60 * 24));
                                echo '<div class="alert alert-info mb-0">';
                                echo '<h6>Akan Dilaksanakan Dalam</h6>';
                                echo '<h3 class="mb-0">' . $days_left . ' Hari</h3>';
                                echo '</div>';
                            } elseif ($event_date == $current_date) {
                                echo '<div class="alert alert-success mb-0">';
                                echo '<h6>Dilaksanakan Hari Ini</h6>';
                                echo '<p class="mb-0">Pukul ' . $event['time'] . '</p>';
                                echo '</div>';
                            } else {
                                echo '<div class="alert alert-secondary mb-0">';
                                echo '<h6>Kegiatan Selesai</h6>';
                                echo '<p class="mb-0">Dilaksanakan pada ' . format_date($event['event_date']) . '</p>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Upcoming Events -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Kegiatan Mendatang</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $current_date = date('Y-m-d');
                            $query_upcoming = "SELECT * FROM events WHERE event_date > '$current_date' AND id != $event_id ORDER BY event_date ASC LIMIT 5";
                            $result_upcoming = mysqli_query($conn, $query_upcoming);
                            
                            if (mysqli_num_rows($result_upcoming) > 0) {
                                while ($row = mysqli_fetch_assoc($result_upcoming)) {
                                    echo '<div class="mb-3 pb-3 border-bottom">';
                                    echo '<h6><a href="event-detail.php?id=' . $row['id'] . '" class="text-decoration-none">' . $row['title'] . '</a></h6>';
                                    echo '<small class="text-muted"><i class="bi bi-calendar3"></i> ' . format_date($row['event_date']) . '</small>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Belum ada kegiatan mendatang.</p>';
                            }
                            ?>
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