<?php
require_once 'config.php';

// Site Settings Functions
function get_site_settings($conn) {
    $settings = array();
    $query = "SELECT setting_key, setting_value FROM site_settings";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    
    return $settings;
}

// Announcement Functions
function get_active_announcement($conn) {
    // Check if user has already closed the announcement
    if (isset($_COOKIE['announcement_closed']) && $_COOKIE['announcement_closed'] == 'true') {
        return null;
    }
    
    $current_date = date('Y-m-d H:i:s');
    $query = "SELECT * FROM announcements 
              WHERE status = 'active' 
              AND start_date <= '$current_date' 
              AND (end_date IS NULL OR end_date >= '$current_date')
              ORDER BY created_at DESC 
              LIMIT 1";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

// Event Functions
function get_next_event($conn) {
    $current_date = date('Y-m-d');
    $query = "SELECT * FROM events 
              WHERE event_date >= '$current_date' 
              ORDER BY event_date ASC 
              LIMIT 1";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

// Council Members Functions
function get_council_members($conn) {
    $members = array();
    $query = "SELECT * FROM council_members 
              WHERE status = 'active' 
              ORDER BY position_order ASC";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $members[] = $row;
        }
    }
    
    return $members;
}

// Gallery Functions
function get_gallery_images($conn, $limit = null, $offset = 0) {
    $images = array();
    $query = "SELECT * FROM gallery ORDER BY created_at DESC";
    
    if ($limit) {
        $query .= " LIMIT $limit OFFSET $offset";
    }
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row;
        }
    }
    
    return $images;
}

function get_gallery_image($conn, $id) {
    $id = (int)$id;
    $query = "SELECT * FROM gallery WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

function count_gallery_images($conn) {
    $query = "SELECT COUNT(*) as total FROM gallery";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Testimonial Functions
function get_testimonials($conn, $limit = null) {
    $testimonials = array();
    $query = "SELECT * FROM testimonials WHERE status = 'active' ORDER BY created_at DESC";
    
    if ($limit) {
        $query .= " LIMIT $limit";
    }
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $testimonials[] = $row;
        }
    }
    
    return $testimonials;
}

// FAQ Functions
function get_faqs($conn, $limit = null) {
    $faqs = array();
    $query = "SELECT * FROM faqs WHERE status = 'active' ORDER BY id ASC";
    
    if ($limit) {
        $query .= " LIMIT $limit";
    }
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $faqs[] = $row;
        }
    }
    
    return $faqs;
}

function search_faqs($conn, $keyword) {
    $keyword = clean_input($keyword);
    $faqs = array();
    
    $query = "SELECT * FROM faqs 
              WHERE status = 'active' 
              AND (question LIKE '%$keyword%' OR answer LIKE '%$keyword%')
              ORDER BY id ASC";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $faqs[] = $row;
        }
    }
    
    return $faqs;
}

// Newsletter Functions
function subscribe_newsletter($conn, $email) {
    $email = clean_input($email);
    
    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return array('success' => false, 'message' => 'Email tidak valid');
    }
    
    // Check if already subscribed
    $query = "SELECT id FROM newsletter_subscribers WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        return array('success' => false, 'message' => 'Email sudah terdaftar');
    }
    
    // Add to database
    $query = "INSERT INTO newsletter_subscribers (email, subscription_date, status) 
              VALUES ('$email', NOW(), 'active')";
    
    if (mysqli_query($conn, $query)) {
        // Send confirmation email (implementation depends on your email service)
        // send_confirmation_email($email);
        
        return array('success' => true, 'message' => 'Berhasil berlangganan newsletter');
    } else {
        return array('success' => false, 'message' => 'Gagal berlangganan newsletter');
    }
}

// Pagination Helper
function get_pagination($total_items, $items_per_page, $current_page) {
    $total_pages = ceil($total_items / $items_per_page);
    
    return array(
        'total_items' => $total_items,
        'items_per_page' => $items_per_page,
        'total_pages' => $total_pages,
        'current_page' => $current_page,
        'has_next' => $current_page < $total_pages,
        'has_prev' => $current_page > 1
    );
}

// File Upload Helper
function upload_file($file, $target_dir, $allowed_types = array()) {
    // Check if file was uploaded
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return array('success' => false, 'message' => 'Tidak ada file yang diupload');
    }
    
    // Check file size (5MB max)
    if ($file['size'] > 5242880) {
        return array('success' => false, 'message' => 'Ukuran file terlalu besar (maksimal 5MB)');
    }
    
    // Check file type
    $file_type = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (!empty($allowed_types) && !in_array(strtolower($file_type), $allowed_types)) {
        return array('success' => false, 'message' => 'Tipe file tidak diizinkan');
    }
    
    // Generate unique filename
    $filename = uniqid() . '.' . $file_type;
    $target_file = $target_dir . $filename;
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return array('success' => true, 'filename' => $filename);
    } else {
        return array('success' => false, 'message' => 'Gagal mengupload file');
    }
}

// Security Functions
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Email Functions (basic implementation)
function send_email($to, $subject, $message) {
    $headers = "From: " . ADMIN_EMAIL . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    return mail($to, $subject, $message, $headers);
}

// Utility Functions
function truncate_text($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

function format_file_size($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return '1 byte';
    } else {
        return '0 bytes';
    }
}
?>