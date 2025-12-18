<?php require_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel - <?php echo SITE_NAME; ?></title>
    
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
                        <a class="nav-link active" href="blog.php">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">Kegiatan</a>
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
            <h1 class="display-4 fw-bold">Artikel OSIS</h1>
            <p class="lead">Informasi terkini seputar kegiatan dan pengumuman OSIS</p>
        </div>
    </div>

    <!-- Blog Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Blog Posts -->
                <div class="col-lg-8">
                    <?php
                    // Pagination
                    $limit = 5;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    
                    // Get total posts
                    $total_query = "SELECT COUNT(*) as total FROM posts";
                    $total_result = mysqli_query($conn, $total_query);
                    $total_posts = mysqli_fetch_assoc($total_result)['total'];
                    $total_pages = ceil($total_posts / $limit);
                    
                    // Get posts
                    $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $offset, $limit";
                    $result = mysqli_query($conn, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="card mb-4 shadow-sm">';
                            echo '<div class="row g-0">';
                            echo '<div class="col-md-4">';
                            echo '<img src="admin/uploads/' . $row['image'] . '" class="img-fluid rounded-start h-100 object-fit-cover" alt="' . $row['title'] . '">';
                            echo '</div>';
                            echo '<div class="col-md-8">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                            echo '<p class="card-text">' . substr($row['content'], 0, 200) . '...</p>';
                            echo '<p class="card-text"><small class="text-muted"><i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . ' | <i class="bi bi-person"></i> ' . $row['author'] . '</small></p>';
                            echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="btn btn-primary">Baca Selengkapnya</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-info">Belum ada artikel tersedia.</div>';
                    }
                    
                    // Pagination
                    if ($total_pages > 1) {
                        echo '<nav aria-label="Page navigation">';
                        echo '<ul class="pagination justify-content-center">';
                        
                        // Previous button
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">&laquo;</a></li>';
                        }
                        
                        // Page numbers
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                        
                        // Next button
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">&raquo;</a></li>';
                        }
                        
                        echo '</ul>';
                        echo '</nav>';
                    }
                    ?>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Categories -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Kategori</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">Pengumuman</a>
                                    <span class="badge bg-primary rounded-pill">0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">Kegiatan</a>
                                    <span class="badge bg-primary rounded-pill">0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">Prestasi</a>
                                    <span class="badge bg-primary rounded-pill">0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">Umum</a>
                                    <span class="badge bg-primary rounded-pill">0</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Recent Posts -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Artikel Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $query_recent = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
                            $result_recent = mysqli_query($conn, $query_recent);
                            
                            if (mysqli_num_rows($result_recent) > 0) {
                                while ($row = mysqli_fetch_assoc($result_recent)) {
                                    echo '<div class="mb-3">';
                                    echo '<h6><a href="blog-detail.php?id=' . $row['id'] . '" class="text-decoration-none">' . $row['title'] . '</a></h6>';
                                    echo '<small class="text-muted"><i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . '</small>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>kdd artikel nyaa nee... stay tune yaa :)</p>';
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