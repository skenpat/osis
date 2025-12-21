<?php 
require_once 'config.php';
require_once 'functions.php'; // New file for helper functions

// Get site settings from database
 $site_settings = get_site_settings($conn);
 $theme_mode = isset($_COOKIE['theme_mode']) ? $_COOKIE['theme_mode'] : 'light';
?>

<!DOCTYPE html>
<html lang="id" data-theme="<?php echo $theme_mode; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Organisasi Siswa Intra Sekolah</title>
    <meta name="description" content="<?php echo $site_settings['meta_description'] ?? 'Organisasi Siswa Intra Sekolah SMK Negeri 4 Banjarmasin'; ?>">
    <meta name="keywords" content="<?php echo $site_settings['meta_keywords'] ?? 'OSIS, SMKN 4 Banjarmasin, Organisasi Siswa'; ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo SITE_NAME; ?> - Organisasi Siswa Intra Sekolah">
    <meta property="og:description" content="<?php echo $site_settings['meta_description'] ?? 'Organisasi Siswa Intra Sekolah SMK Negeri 4 Banjarmasin'; ?>">
    <meta property="og:image" content="<?php echo BASE_URL; ?>assets/images/og-image.jpg">
    <meta property="og:url" content="<?php echo BASE_URL; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" as="style">
    <link rel="preload" href="assets/css/style.css" as="style">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Theme Toggle CSS -->
    <link href="assets/css/theme-toggle.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        
        /* Dark mode variables */
        [data-theme="dark"] {
            --dark-color: #f8f9fa;
            --light-color: #2b2d42;
            --card-bg: #343a40;
            --text-color: #e9ecef;
            --footer-bg: #212529;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s, color 0.3s;
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        [data-theme="dark"] .navbar {
            background: rgba(52, 58, 64, 0.95);
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
        
        /* Theme Toggle Button */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--dark-color);
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .theme-toggle:hover {
            transform: rotate(180deg);
        }
        
        /* Announcement Banner */
        .announcement-banner {
            background: var(--accent-color);
            color: white;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }
        
        .announcement-banner .close-btn {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            cursor: pointer;
        }
        
        /* Hero Section */
        .hero-section {
            background: var(--gradient);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://ik.imagekit.io/fles/ketos_reno.jpg?updatedAt=1766154448985') center/cover;
            opacity: 0.15;
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-weight: 800;
            margin-bottom: 1.5rem;
            font-size: 3.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .hero-buttons .btn {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            margin-right: 15px;
            transition: all 0.3s ease;
        }
        
        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
        }
        
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-hero-outline {
            border: 2px solid white;
            color: white;
        }
        
        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-color);
        }
        
        .hero-image {
            position: relative;
            z-index: 1;
        }
        
        .hero-image img {
            border-radius: 20px;
            max-width: 70%;
            height: auto;
        }
        
        /* Floating Animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        /* Section Styling */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        
        .section-subtitle {
            color: #6c757d;
            margin-bottom: 3rem;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--accent-color);
            margin: 15px 0;
        }
        
        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
        }
        
        [data-theme="dark"] .feature-card {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .feature-icon i {
            font-size: 30px;
            color: white;
        }
        
        /* News Cards */
        .news-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        [data-theme="dark"] .news-card {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .news-card img {
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .news-card:hover img {
            transform: scale(1.05);
        }
        
        .news-card-body {
            padding: 20px;
        }
        
        .news-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        /* Event Cards */
        .event-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }
        
        [data-theme="dark"] .event-card {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
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
            padding: 20px;
        }
        
        .event-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .event-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .event-meta i {
            margin-right: 5px;
        }
        
        /* Countdown Timer */
        .countdown-timer {
            background: var(--gradient);
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        
        .countdown-item {
            display: inline-block;
            margin: 0 15px;
            text-align: center;
        }
        
        .countdown-value {
            font-size: 2.5rem;
            font-weight: 700;
            display: block;
        }
        
        .countdown-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* Testimonial Section */
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        
        [data-theme="dark"] .testimonial-card {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .testimonial-quote {
            font-size: 1.1rem;
            font-style: italic;
            margin-bottom: 20px;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .testimonial-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .testimonial-author h5 {
            margin: 0;
            font-weight: 600;
        }
        
        .testimonial-author p {
            margin: 0;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        /* Gallery Section */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
            cursor: pointer;
        }
        
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-overlay i {
            color: white;
            font-size: 2rem;
        }
        
        /* CTA Section */
        .cta-section {
            background: var(--gradient);
            padding: 80px 0;
            color: white;
            text-align: center;
        }
        
        .cta-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .cta-subtitle {
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .btn-cta {
            background: white;
            color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }
        
        [data-theme="dark"] footer {
            background: var(--footer-bg);
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
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background: var(--secondary-color);
            transform: translateY(-5px);
        }
        
        /* Calendar Widget */
        .calendar-widget {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        [data-theme="dark"] .calendar-widget {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .calendar-nav {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .calendar-day:hover {
            background: rgba(67, 97, 238, 0.1);
        }
        
        .calendar-day.today {
            background: var(--primary-color);
            color: white;
        }
        
        .calendar-day.has-event {
            position: relative;
        }
        
        .calendar-day.has-event::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--accent-color);
        }
        
        /* Live Chat Widget */
        .chat-widget {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 999;
        }
        
        .chat-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .chat-button:hover {
            transform: scale(1.1);
        }
        
        .chat-box {
            position: absolute;
            bottom: 80px;
            left: 0;
            width: 350px;
            height: 450px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: none;
            flex-direction: column;
            overflow: hidden;
        }
        
        [data-theme="dark"] .chat-box {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .chat-box.active {
            display: flex;
        }
        
        .chat-header {
            background: var(--gradient);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chat-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        .chat-body {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
        }
        
        .chat-message {
            margin-bottom: 15px;
            display: flex;
        }
        
        .chat-message.user {
            justify-content: flex-end;
        }
        
        .chat-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
        }
        
        .chat-message.bot .chat-bubble {
            background: #f1f1f1;
            border-top-left-radius: 0;
        }
        
        [data-theme="dark"] .chat-message.bot .chat-bubble {
            background: #495057;
        }
        
        .chat-message.user .chat-bubble {
            background: var(--primary-color);
            color: white;
            border-top-right-radius: 0;
        }
        
        .chat-footer {
            padding: 15px;
            border-top: 1px solid #eee;
        }
        
        [data-theme="dark"] .chat-footer {
            border-top-color: #495057;
        }
        
        .chat-input {
            display: flex;
        }
        
        .chat-input input {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 8px 15px;
            margin-right: 10px;
        }
        
        [data-theme="dark"] .chat-input input {
            background: #495057;
            border-color: #6c757d;
            color: var(--text-color);
        }
        
        .chat-input button {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        /* Student Council Section */
        .council-member {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .council-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 5px solid var(--primary-color);
        }
        
        .council-member h5 {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .council-member p {
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .council-member .social-links a {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            margin: 0 5px;
        }
        
        /* FAQ Section */
        .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 10px !important;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        [data-theme="dark"] .accordion-item {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .accordion-button {
            background: white;
            color: var(--dark-color);
            font-weight: 600;
            box-shadow: none;
        }
        
        [data-theme="dark"] .accordion-button {
            background: var(--card-bg);
            color: var(--text-color);
        }
        
        .accordion-button:not(.collapsed) {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .accordion-button:focus {
            box-shadow: none;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-image {
                margin-top: 50px;
            }
            
            .chat-box {
                width: 300px;
                height: 400px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-section {
                padding: 100px 0 60px;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .countdown-item {
                margin: 0 5px;
            }
            
            .countdown-value {
                font-size: 1.8rem;
            }
            
            .chat-widget {
                left: 20px;
                bottom: 20px;
            }
            
            .chat-box {
                width: calc(100vw - 40px);
                left: -10px;
            }
        }
    </style>
</head>
<body>
    <!-- Announcement Banner -->
    <?php
    $announcement = get_active_announcement($conn);
    if ($announcement):
    ?>
    <div class="announcement-banner" id="announcement-banner">
        <div class="container">
            <i class="bi bi-megaphone-fill me-2"></i>
            <?php echo $announcement['message']; ?>
            <button class="close-btn" onclick="closeAnnouncement()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>

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
                        <a class="nav-link active" href="index.php">Beranda</a>
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
                        <a class="nav-link" href="gallery.php">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link theme-toggle" id="theme-toggle">
                            <i class="bi bi-moon-fill" id="theme-icon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content" data-aos="fade-up">
                    <h1 class="hero-title text-white">Selamat Datang di <?php echo SITE_NAME; ?></h1>
                    <p class="hero-subtitle text-white">Mewujudkan generasi muda yang berprestasi, berkarakter, dan berkontribusi positif bagi sekolah dan masyarakat.</p>
                    <div class="hero-buttons">
                        <a href="#about" class="btn btn-hero-primary">Tentang Kami</a>
                        <a href="#events" class="btn btn-hero-outline">Kegiatan Terbaru</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image" data-aos="fade-left">
                    <img src="https://res.cloudinary.com/dahcxjdbl/image/upload/v1766196359/osis4_100x_vnzamj.png" alt="Logo OSIS" class="floating">
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Timer Section -->
    <?php
    $next_event = get_next_event($conn);
    if ($next_event):
    ?>
    <section class="countdown-timer">
        <div class="container">
            <h3 class="mb-4"><?php echo $next_event['title']; ?> Akan Datang</h3>
            <div class="countdown" id="countdown" data-date="<?php echo $next_event['event_date']; ?>">
                <div class="countdown-item">
                    <span class="countdown-value" id="days">00</span>
                    <span class="countdown-label">Hari</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value" id="hours">00</span>
                    <span class="countdown-label">Jam</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value" id="minutes">00</span>
                    <span class="countdown-label">Menit</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value" id="seconds">00</span>
                    <span class="countdown-label">Detik</span>
                </div>
            </div>
            <a href="event-detail.php?id=<?php echo $next_event['id']; ?>" class="btn btn-light mt-3">Detail Kegiatan</a>
        </div>
    </section>
    <?php endif; ?>

    <!-- Features Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Tentang OSIS</h2>
                    <p class="section-subtitle">Mengenal lebih dekat visi, misi, dan program kerja kami</p>
                </div>
                <div class="col-lg-6 mb-4" data-aos="fade-right">
                    <h3 class="fw-bold mb-3">Visi</h3>
                    <p>Menjadi organisasi siswa yang inovatif, kreatif, dan berprestasi dalam mengembangkan potensi diri serta berkontribusi aktif bagi kemajuan sekolah dan masyarakat.</p>
                </div>
                <div class="col-lg-6 mb-4" data-aos="fade-left">
                    <h3 class="fw-bold mb-3">Misi</h3>
                    <ul>
                        <li>Meningkatkan kualitas sumber daya manusia melalui berbagai kegiatan pengembangan diri</li>
                        <li>Menjalin kerjasama yang harmonis antar siswa, guru, dan masyarakat</li>
                        <li>Menumbuhkan jiwa kepemimpinan dan kemandirian siswa</li>
                        <li>Menjadi wadah aspirasi dan kreativitas siswa</li>
                    </ul>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4>Kerjasama</h4>
                        <p>Membangun tim yang solid dan saling mendukung untuk mencapai tujuan bersama.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightbulb-fill"></i>
                        </div>
                        <h4>Inovasi</h4>
                        <p>Terus berkreativitas dan mencari ide-ide baru untuk kemajuan organisasi.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h4>Integritas</h4>
                        <p>Bertindak jujur, bertanggung jawab, dan menjunjung tinggi nilai-nilai luhur.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Student Council Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Pengurus OSIS</h2>
                    <p class="section-subtitle">Tim yang berdedikasi untuk melayani siswa</p>
                </div>
                <?php
                $council_members = get_council_members($conn);
                if (count($council_members) > 0):
                    foreach ($council_members as $member):
                ?>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="council-member">
                        <img src="admin/uploads/<?php echo $member['photo']; ?>" alt="<?php echo $member['name']; ?>">
                        <h5><?php echo $member['name']; ?></h5>
                        <p><?php echo $member['position']; ?></p>
                        <div class="social-links">
                            <?php if (!empty($member['instagram'])): ?>
                            <a href="<?php echo $member['instagram']; ?>"><i class="bi bi-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($member['twitter'])): ?>
                            <a href="<?php echo $member['twitter']; ?>"><i class="bi bi-twitter"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($member['linkedin'])): ?>
                            <a href="<?php echo $member['linkedin']; ?>"><i class="bi bi-linkedin"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                else:
                ?>
                <div class="col-12 text-center">
                    <p>Belum ada data pengurus OSIS.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Artikel Terbaru</h2>
                    <p class="section-subtitle">Informasi terkini seputar kegiatan dan pengumuman OSIS</p>
                </div>
                <?php
                $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">';
                        echo '<div class="news-card">';
                        echo '<img src="admin/uploads/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">';
                        echo '<div class="news-card-body">';
                        echo '<div class="news-meta"><i class="bi bi-calendar3"></i> ' . format_date($row['created_at']) . '</div>';
                        echo '<h5 class="card-title">' . $row['title'] . '</h5>';
                        echo '<p class="card-text">' . substr($row['content'], 0, 150) . '...</p>';
                        echo '<a href="blog-detail.php?id=' . $row['id'] . '" class="btn btn-primary">Baca Selengkapnya</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada artikel tersedia.</p></div>';
                }
                ?>
                <div class="col-12 text-center mt-4" data-aos="fade-up">
                    <a href="blog.php" class="btn btn-outline-primary">Lihat Semua Artikel</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section id="events" class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Kegiatan Mendatang</h2>
                    <p class="section-subtitle">Jangan lewatkan kegiatan-kegiatan menarik dari OSIS</p>
                </div>
                <?php
                $current_date = date('Y-m-d');
                $query = "SELECT * FROM events WHERE event_date >= '$current_date' ORDER BY event_date ASC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $event_date = strtotime($row['event_date']);
                        $day = date('d', $event_date);
                        $month = date('M', $event_date);
                        
                        echo '<div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">';
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
                        echo '<p>' . substr($row['description'], 0, 100) . '...</p>';
                        echo '<a href="event-detail.php?id=' . $row['id'] . '" class="btn btn-primary">Detail Kegiatan</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada kegiatan mendatang.</p></div>';
                }
                ?>
                <div class="col-12 text-center mt-4" data-aos="fade-up">
                    <a href="events.php" class="btn btn-outline-primary">Lihat Semua Kegiatan</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Galeri Kegiatan</h2>
                    <p class="section-subtitle">Dokumentasi kegiatan OSIS</p>
                </div>
                <?php
                $query = "SELECT * FROM gallery ORDER BY created_at DESC LIMIT 8";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">';
                        echo '<div class="gallery-item" onclick="openGalleryModal(' . $row['id'] . ')">';
                        echo '<img src="admin/uploads/gallery/' . $row['image'] . '" alt="' . $row['title'] . '">';
                        echo '<div class="gallery-overlay">';
                        echo '<i class="bi bi-zoom-in"></i>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada foto galeri.</p></div>';
                }
                ?>
                <div class="col-12 text-center mt-4" data-aos="fade-up">
                    <a href="gallery.php" class="btn btn-outline-primary">Lihat Semua Foto</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Testimoni</h2>
                    <p class="section-subtitle">Apa kata mereka tentang OSIS</p>
                </div>
                <?php
                $query = "SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 3";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">';
                        echo '<div class="testimonial-card">';
                        echo '<div class="testimonial-quote">';
                        echo '<i class="bi bi-quote text-primary fs-2"></i>';
                        echo '<p class="mt-2">' . $row['message'] . '</p>';
                        echo '</div>';
                        echo '<div class="testimonial-author">';
                        echo '<img src="admin/uploads/testimonials/' . $row['photo'] . '" alt="' . $row['name'] . '">';
                        echo '<div>';
                        echo '<h5>' . $row['name'] . '</h5>';
                        echo '<p>' . $row['position'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12 text-center"><p>Belum ada testimoni.</p></div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
                    <p class="section-subtitle">Temukan jawaban untuk pertanyaan Anda</p>
                </div>
                <div class="col-lg-8 mx-auto" data-aos="fade-up">
                    <div class="accordion" id="faqAccordion">
                        <?php
                        $query = "SELECT * FROM faqs ORDER BY id ASC LIMIT 5";
                        $result = mysqli_query($conn, $query);
                        
                        if (mysqli_num_rows($result) > 0) {
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $count++;
                                echo '<div class="accordion-item">';
                                echo '<h2 class="accordion-header" id="heading' . $count . '">';
                                echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $count . '"';
                                if ($count > 1) echo 'collapsed';
                                echo '>';
                                echo $row['question'];
                                echo '</button>';
                                echo '</h2>';
                                echo '<div id="collapse' . $count . '" class="accordion-collapse collapse';
                                if ($count == 1) echo ' show';
                                echo '" data-bs-parent="#faqAccordion">';
                                echo '<div class="accordion-body">';
                                echo $row['answer'];
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="text-center"><p>Belum ada FAQ.</p></div>';
                        }
                        ?>
                    </div>
                    <div class="text-center mt-4">
                        <a href="faq.php" class="btn btn-outline-primary">Lihat Semua FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-aos="fade-up">
                    <h2 class="cta-title">Bergabunglah Bersama Kami</h2>
                    <p class="cta-subtitle">Mari wujudkan generasi muda yang berprestasi, berkarakter, dan berkontribusi positif bagi sekolah dan masyarakat.</p>
                    <a href="contact.php" class="btn btn-cta">Hubungi Kami</a>
                </div>
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
                        <li><a href="gallery.php">Galeri</a></li>
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
                    <form action="subscribe.php" method="POST">
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
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

    <!-- Back to Top Button -->
    <div class="back-to-top" id="back-to-top">
        <i class="bi bi-arrow-up"></i>
    </div>

    <!-- Live Chat Widget -->
    <div class="chat-widget">
        <div class="chat-box" id="chat-box">
            <div class="chat-header">
                <h5 class="mb-0">Bantuan</h5>
                <button class="chat-close" id="chat-close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="chat-body" id="chat-body">
                <div class="chat-message bot">
                    <div class="chat-bubble">
                        Halo! Ada yang bisa saya bantu?
                    </div>
                </div>
            </div>
            <div class="chat-footer">
                <div class="chat-input">
                    <input type="text" id="chat-input" placeholder="Ketik pesan...">
                    <button id="chat-send">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="chat-button" id="chat-button">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalTitle">Galeri Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="galleryModalImage" src="" alt="" class="img-fluid">
                    <p id="galleryModalCaption" class="mt-3"></p>
                </div>
            </div>
        </div>
    </div>

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
        
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;
        
        // Check for saved theme preference or default to light
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);
        
        themeToggle.addEventListener('click', function() {
            const theme = html.getAttribute('data-theme');
            const newTheme = theme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            document.cookie = `theme_mode=${newTheme}; path=/; max-age=31536000`; // 1 year
            updateThemeIcon(newTheme);
        });
        
        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.classList.remove('bi-moon-fill');
                themeIcon.classList.add('bi-sun-fill');
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-fill');
            }
        }
        
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
            
            // Back to top button
            const backToTop = document.getElementById('back-to-top');
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        
        // Back to top
        document.getElementById('back-to-top').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Countdown Timer
        function initCountdown() {
            const countdownElement = document.getElementById('countdown');
            if (!countdownElement) return;
            
            const eventDate = new Date(countdownElement.getAttribute('data-date')).getTime();
            
            const countdownInterval = setInterval(function() {
                const now = new Date().getTime();
                const distance = eventDate - now;
                
                if (distance < 0) {
                    clearInterval(countdownInterval);
                    document.getElementById('days').innerText = '00';
                    document.getElementById('hours').innerText = '00';
                    document.getElementById('minutes').innerText = '00';
                    document.getElementById('seconds').innerText = '00';
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                document.getElementById('days').innerText = days < 10 ? '0' + days : days;
                document.getElementById('hours').innerText = hours < 10 ? '0' + hours : hours;
                document.getElementById('minutes').innerText = minutes < 10 ? '0' + minutes : minutes;
                document.getElementById('seconds').innerText = seconds < 10 ? '0' + seconds : seconds;
            }, 1000);
        }
        
        // Initialize countdown if exists
        initCountdown();
        
        // Close Announcement Banner
        function closeAnnouncement() {
            const banner = document.getElementById('announcement-banner');
            if (banner) {
                banner.style.display = 'none';
                // Save to cookies that user has closed the announcement
                document.cookie = 'announcement_closed=true; path=/; max-age=86400'; // 1 day
            }
        }
        
        // Chat Widget
        const chatButton = document.getElementById('chat-button');
        const chatBox = document.getElementById('chat-box');
        const chatClose = document.getElementById('chat-close');
        const chatInput = document.getElementById('chat-input');
        const chatSend = document.getElementById('chat-send');
        const chatBody = document.getElementById('chat-body');
        
        chatButton.addEventListener('click', function() {
            chatBox.classList.add('active');
        });
        
        chatClose.addEventListener('click', function() {
            chatBox.classList.remove('active');
        });
        
        function sendMessage() {
            const message = chatInput.value.trim();
            if (message === '') return;
            
            // Add user message
            const userMessage = document.createElement('div');
            userMessage.className = 'chat-message user';
            userMessage.innerHTML = `
                <div class="chat-bubble">${message}</div>
            `;
            chatBody.appendChild(userMessage);
            
            // Clear input
            chatInput.value = '';
            
            // Scroll to bottom
            chatBody.scrollTop = chatBody.scrollHeight;
            
            // Simulate bot response
            setTimeout(function() {
                const botMessage = document.createElement('div');
                botMessage.className = 'chat-message bot';
                botMessage.innerHTML = `
                    <div class="chat-bubble">Terima kasih atas pesan Anda. Kami akan segera merespons.</div>
                `;
                chatBody.appendChild(botMessage);
                chatBody.scrollTop = chatBody.scrollHeight;
            }, 1000);
        }
        
        chatSend.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        // Gallery Modal
        function openGalleryModal(imageId) {
            // In a real implementation, you would fetch image details from the server
            // For now, we'll use placeholder data
            const modalImage = document.getElementById('galleryModalImage');
            const modalTitle = document.getElementById('galleryModalTitle');
            const modalCaption = document.getElementById('galleryModalCaption');
            
            // This is just a placeholder - in a real implementation, you would fetch the actual image data
            modalImage.src = `admin/uploads/gallery/${imageId}.jpg`;
            modalCaption.textContent = `Foto ${imageId} dari galeri OSIS`;
            
            const galleryModal = new bootstrap.Modal(document.getElementById('galleryModal'));
            galleryModal.show();
        }
    </script>
</body>
</html>