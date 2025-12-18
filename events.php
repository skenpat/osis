<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan - <?php echo SITE_NAME; ?></title>
    
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
                        <a class="nav-link active" href="events.php">Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="bg-primary text-white py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Kegiatan OSIS</h1>
            <p class="lead">Jadwal kegiatan dan program OSIS terkini</p>
        </div>
    </div>

    <!-- Events Content -->
    <section class="py-5">
        <div class="container">
            <!-- Event Filter -->
            <div class="row mb-4">
                <div class="col-12">
                    <ul class="nav nav-pills" id="eventFilter" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="pill" data-bs-target="#upcoming" type="button" role="tab">Kegiatan Mendatang</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-tab" data-bs-toggle="pill" data-bs-target="#past" type="button" role="tab">Kegiatan Selesai</button>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Event Content -->
            <div class="tab-content" id="eventFilterContent">
                <!-- Upcoming Events -->
                <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                    <div class="row">
                        <?php
                        $current_date = date('Y-m-d');
                        $query = "SELECT * FROM events WHERE event_date >= '$current_date' ORDER BY event_date ASC";
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
                            echo '<div class="col-12 text-center"><div class="alert alert-info">Belum ada kegiatan mendatang.</div></div>';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Past Events -->
                <div class="tab-pane fade" id="past" role="tabpanel">
                    <div class="row">
                        <?php
                        $current_date = date('Y-m-d');
                        $query = "SELECT * FROM events WHERE event_date < '$current_date' ORDER BY event_date DESC";
                        $result = mysqli_query($conn, $query);
                        
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="col-lg-4 mb-4">';
                                echo '<div class="card h-100 shadow-sm">';
                                echo '<div class="card-header bg-secondary text-white">';
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
                                echo '<a href="event-detail.php?id=' . $row['id'] . '" class="btn btn-secondary">Detail Kegiatan</a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="col-12 text-center"><div class="alert alert-info">Belum ada kegiatan yang telah selesai.</div></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Calendar Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Kalender Kegiatan</h2>
                    <div class="underline mx-auto"></div>
                </div>
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Calendar Placeholder -->
                            <div id="calendar" class="calendar-container">
                                <p class="text-center">Kalender kegiatan akan segera tersedia.</p>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>
</html>