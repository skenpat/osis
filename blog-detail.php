<?php require_once 'config.php'; ?>

<?php
// Get post ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('blog.php');
}

 $post_id = (int)$_GET['id'];

// Get post data
 $query = "SELECT * FROM posts WHERE id = $post_id";
 $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    redirect('blog.php');
}

 $post = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?> - <?php echo SITE_NAME; ?></title>
    
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

    <!-- Blog Detail Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <img src="admin/uploads/<?php echo $post['image']; ?>" class="card-img-top" alt="<?php echo $post['title']; ?>">
                        <div class="card-body">
                            <h1 class="card-title mb-3"><?php echo $post['title']; ?></h1>
                            <p class="text-muted mb-4">
                                <i class="bi bi-person"></i> <?php echo $post['author']; ?> | 
                                <i class="bi bi-calendar3"></i> <?php echo format_date($post['created_at']); ?> | 
                                <i class="bi bi-folder"></i> <?php echo $post['category']; ?>
                            </p>
                            <div class="card-text">
                                <?php echo nl2br($post['content']); ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="blog.php" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Kembali ke Berita</a>
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="bi bi-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Posts -->
                    <div class="mt-5">
                        <h3 class="mb-4">Berita Terkait</h3>
                        <div class="row">
                            <?php
                            $query_related = "SELECT * FROM posts WHERE id != $post_id AND category = '" . $post['category'] . "' ORDER BY created_at DESC LIMIT 3";
                            $result_related = mysqli_query($conn, $query_related);
                            
                            if (mysqli_num_rows($result_related) > 0) {
                                while ($row = mysqli_fetch_assoc($result_related)) {
                                    echo '<div class="col-md-4 mb-4">';
                                    echo '<div class="card h-100 shadow-sm">';
                                    echo '<img src="admin/uploads/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">';
                                    echo '<div class="card-body">';
                                    echo '<h6 class="card-title">' . $row['title'] . '</h6>';
                                    echo '<p class="card-text">' . substr($row['content'], 0, 100) . '...</p>';
                                    echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary">Baca Selengkapnya</a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                // If no related posts in same category, show recent posts
                                $query_recent = "SELECT * FROM posts WHERE id != $post_id ORDER BY created_at DESC LIMIT 3";
                                $result_recent = mysqli_query($conn, $query_recent);
                                
                                if (mysqli_num_rows($result_recent) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_recent)) {
                                        echo '<div class="col-md-4 mb-4">';
                                        echo '<div class="card h-100 shadow-sm">';
                                        echo '<img src="admin/uploads/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">';
                                        echo '<div class="card-body">';
                                        echo '<h6 class="card-title">' . $row['title'] . '</h6>';
                                        echo '<p class="card-text">' . substr($row['content'], 0, 100) . '...</p>';
                                        echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary">Baca Selengkapnya</a>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
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
                                    <span class="badge bg-primary rounded-pill">5</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">Kegiatan</a>
                                    <span class="badge bg-primary rounded-pill">8</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">Prestasi</a>
                                    <span class="badge bg-primary rounded-pill">3</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">Umum</a>
                                    <span class="badge bg-primary rounded-pill">7</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Recent Posts -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Berita Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $query_recent = "SELECT * FROM posts WHERE id != $post_id ORDER BY created_at DESC LIMIT 5";
                            $result_recent = mysqli_query($conn, $query_recent);
                            
                            if (mysqli_num_rows($result_recent) > 0) {
                                while ($row = mysqli_fetch_assoc($result_recent)) {
                                    echo '<div class="mb-3">';
                                    echo '<h6><a href="blog-detail.php?id=' . $row['id'] . '" class="text-decoration-none">' . $row['title'] . '</a></h6>';
                                    echo '<small class="text-muted"><i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . '</small>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>Belum ada berita tersedia.</p>';
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