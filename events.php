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
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        /* Page Header */
        .page-header {
            background: var(--gradient);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80') center/cover;
            opacity: 0.15;
            z-index: 0;
        }
        
        .page-header-content {
            position: relative;
            z-index: 1;
        }
        
        .page-title {
            font-weight: 800;
            margin-bottom: 1rem;
            font-size: 3rem;
        }
        
        .page-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
        }
        
        /* Events Section */
        .events-section {
            padding: 80px 0;
        }
        
        /* Event Cards */
        .event-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .event-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .event-date {
            background: var(--gradient);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 700;
        }
        
        .event-date .day {
            font-size: 2rem;
            line-height: 1;
        }
        
        .event-date .month {
            font-size: 0.9rem;
        }
        
        .event-body {
            padding: 25px;
        }
        
        .event-title {
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }
        
        .event-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .event-meta i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .event-meta div {
            margin-bottom: 8px;
        }
        
        .event-description {
            color: #333;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .event-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .event-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            color: white;
        }
        
        /* Event Filters */
        .event-filters {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }
        
        .filter-btn {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--gradient);
            color: white;
            border-color: transparent;
        }
        
        /* Calendar View */
        .calendar-view {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .calendar-nav {
            background: var(--gradient);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .calendar-nav:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .calendar-day:hover {
            background: var(--light-color);
        }
        
        .calendar-day.has-event {
            background: var(--gradient);
            color: white;
        }
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer-logo {
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: white;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
            padding-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .page-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .page-header {
                padding: 100px 0 60px;
            }
            
            .events-section {
                padding: 60px 0;
            }
            
            .calendar-grid {
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
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
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php"><i class="bi bi-lock-fill"></i> Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content text-center text-white" data-aos="fade-up">
                <h1 class="page-title">Kegiatan OSIS</h1>
                <p class="page-subtitle">Jadwal kegiatan dan event terbaru dari OSIS SMK Negeri 4 Banjarmasin</p>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events-section">
        <div class="container">
            <!-- Event Filters -->
            <div class="event-filters" data-aos="fade-up">
                <h5 class="mb-3">Filter Kegiatan</h5>
                <button class="filter-btn active">Semua</button>
                <button class="filter-btn">Akademik</button>
                <button class="filter-btn">Olahraga</button>
                <button class="filter-btn">Seni</button>
                <button class="filter-btn">Sosial</button>
            </div>
            
            <!-- Calendar View -->
            <div class="calendar-view" data-aos="fade-up">
                <div class="calendar-header">
                    <button class="calendar-nav"><i class="bi bi-chevron-left"></i></button>
                    <h4>Januari 2025</h4>
                    <button class="calendar-nav"><i class="bi bi-chevron-right"></i></button>
                </div>
                <div class="calendar-grid">
                    <div class="calendar-day">Min</div>
                    <div class="calendar-day">Sen</div>
                    <div class="calendar-day">Sel</div>
                    <div class="calendar-day">Rab</div>
                    <div class="calendar-day">Kam</div>
                    <div class="calendar-day">Jum</div>
                    <div class="calendar-day">Sab</div>
                    <div class="calendar-day">1</div>
                    <div class="calendar-day">2</div>
                    <div class="calendar-day">3</div>
                    <div class="calendar-day">4</div>
                    <div class="calendar-day">5</div>
                    <div class="calendar-day">6</div>
                    <div class="calendar-day">7</div>
                    <div class="calendar-day">8</div>
                    <div class="calendar-day">9</div>
                    <div class="calendar-day">10</div>
                    <div class="calendar-day">11</div>
                    <div class="calendar-day">12</div>
                    <div class="calendar-day">13</div>
                    <div class="calendar-day">14</div>
                    <div class="calendar-day has-event">15</div>
                    <div class="calendar-day">16</div>
                    <div class="calendar-day">17</div>
                    <div class="calendar-day">18</div>
                    <div class="calendar-day">19</div>
                    <div class="calendar-day">20</div>
                    <div class="calendar-day">21</div>
                    <div class="calendar-day">22</div>
                    <div class="calendar-day">23</div>
                    <div class="calendar-day">24</div>
                    <div class="calendar-day">25</div>
                    <div class="calendar-day">26</div>
                    <div class="calendar-day">27</div>
                    <div class="calendar-day">28</div>
                    <div class="calendar-day">29</div>
                    <div class="calendar-day">30</div>
                    <div class="calendar-day">31</div>
                </div>
            </div>
            
            <!-- Upcoming Events -->
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Kegiatan Mendatang</h2>
                    <p class="section-subtitle">Jangan lewatkan kegiatan-kegiatan menarik dari OSIS</p>
                </div>
                <?php
                $current_date = date('Y-m-d');
                $query = "SELECT * FROM events WHERE event_date >= '$current_date' ORDER BY event_date ASC LIMIT 6";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $event_date = strtotime($row['event_date']);
                        $day = date('d', $event_date);
                        $month = date('M', $event_date);
                        
                        echo '<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">';
                        echo '<div class="event-card">';
                        echo '<div class="event-date">';
                        echo '<div class="day">' . $day . '</div>';
                        echo '<div class="month">' . $month . '</div>';
                        echo '</div>';
                        echo '<div class="event-body">';
                        echo '<h5 class="event-title">' . $row['title'] . '</h5>';
                        echo '<div class="event-meta">';
                        echo '<div><i class="bi bi-geo-alt"></i> ' . $row['location'] . '</div>';
                        echo '<div><i class="bi bi-clock"></i> ' . $row['time'] . '</div>';
                        echo '</div>';
                        echo '<p class="event-description">' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<a href="event-detail.php?id=' . $row['id'] . '" class="event-btn">Detail Kegiatan</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada kegiatan mendatang.</p></div>';
                }
                ?>
            </div>
            
            <!-- Past Events -->
            <div class="row mt-5">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Kegiatan Terlaksana</h2>
                    <p class="section-subtitle">Dokumentasi kegiatan yang telah dilaksanakan</p>
                </div>
                <?php
                $query = "SELECT * FROM events WHERE event_date < '$current_date' ORDER BY event_date DESC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $event_date = strtotime($row['event_date']);
                        $day = date('d', $event_date);
                        $month = date('M', $event_date);
                        
                        echo '<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">';
                        echo '<div class="event-card">';
                        echo '<img src="https://picsum.photos/seed/event' . $row['id'] . '/400/200.jpg" class="event-image" alt="' . $row['title'] . '">';
                        echo '<div class="event-body">';
                        echo '<h5 class="event-title">' . $row['title'] . '</h5>';
                        echo '<div class="event-meta">';
                        echo '<div><i class="bi bi-calendar3"></i> ' . format_date($row['event_date']) . '</div>';
                        echo '<div><i class="bi bi-geo-alt"></i> ' . $row['location'] . '</div>';
                        echo '</div>';
                        echo '<p class="event-description">' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<a href="event-detail.php?id=' . $row['id'] . '" class="event-btn">Lihat Dokumentasi</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada kegiatan yang terlaksana.</p></div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="footer-logo"><?php echo SITE_NAME; ?></h3>
                    <p>Organisasi Siswa Intra Sekolah SMK Negeri 4 Banjarmasin</p>
                    <div class="social-icons">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSe7yFwJSVqAJTHqwoAi5F9b1rO13Y_HYC-vwROWif11wC1NOg/viewform"><i class="bi-box-arrow-in-down-right"></i></a>
                        <a href="https://www.tiktok.com/@osissmkn4bjm/"><i class="bi bi-tiktok"></i></a>
                        <a href="https://www.instagram.com/osissmkn4bjm/"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/@smknegeri4banjarmasin931"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Menu</h5>
                    <ul class="footer-links">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="about.php">Tentang</a></li>
                        <li><a href="blog.php">Artikel</a></li>
                        <li><a href="events.php">Kegiatan</a></li>
                        <li><a href="contact.php">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Informasi Kontak</h5>
                    <ul class="footer-links">
                        <li><i class="bi bi-geo-alt"></i> Jl. Brigjend H. Hasan Basri, Sungai Miai, Banjarmasin</li>
                        <li><i class="bi bi-telephone"></i> (021) 1234-5678</li>
                        <li><i class="bi bi-envelope"></i> skenpat-people@gmail.com</li>
                        <li><i class="bi bi-clock"></i> Senin - Jumat: 08.00 - 16.00</li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h5>Newsletter</h5>
                    <p>Dapatkan informasi terbaru dari kami</p>
                    <form action="#" method="POST">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email Anda" required>
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved. Developed by <a href="https://github.com/orgs/skenpat/people">skenpat-people</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '10px 0';
                navbar.style.boxShadow = '0 5px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.padding = '15px 0';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });
        
        // Filter buttons
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>