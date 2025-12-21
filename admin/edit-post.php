<?php
require_once '../config.php';
require_login();

// Get post ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('posts.php');
}

 $post_id = (int)$_GET['id'];

// Get post data
 $query = "SELECT * FROM posts WHERE id = $post_id";
 $result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    redirect('posts.php');
}

 $post = mysqli_fetch_assoc($result);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = clean_input($_POST['title']);
    $content = clean_input($_POST['content']);
    $category = clean_input($_POST['category']);
    $author = clean_input($_POST['author']);
    $current_image = $post['image'];
    
    // Validate form data
    if (empty($title) || empty($content) || empty($category) || empty($author)) {
        $error = "Semua field harus diisi.";
    } else {
        // Handle image upload
        $image = $current_image;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $file_name = time() . '_' . $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $upload_dir = '../uploads/';
                
                if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                    // Delete old image if exists
                    if (!empty($current_image) && file_exists($upload_dir . $current_image)) {
                        unlink($upload_dir . $current_image);
                    }
                    
                    $image = $file_name;
                } else {
                    $error = "Gagal mengupload gambar.";
                }
            } else {
                $error = "Format gambar tidak valid. Hanya JPEG, JPG, PNG, dan GIF yang diperbolehkan.";
            }
        }
        
        if (!isset($error)) {
            // Update post in database
            $query = "UPDATE posts SET 
                      title = '$title', 
                      content = '$content', 
                      category = '$category', 
                      author = '$author', 
                      image = '$image' 
                      WHERE id = $post_id";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Artikel berhasil diperbarui.";
                redirect('posts.php');
            } else {
                $error = "Terjadi kesalahan. Artikel gagal diperbarui.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel - Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --sidebar-width: 280px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fb;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--dark-color);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }
        
        .sidebar-logo i {
            font-size: 1.5rem;
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .sidebar-logo span {
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            display: block;
            padding: 15px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .menu-item i {
            margin-right: 15px;
            font-size: 1.1rem;
            width: 20px;
        }
        
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 30px;
        }
        
        .menu-item.active {
            background: var(--gradient);
            color: white;
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--accent-color);
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .user-role {
            font-size: 0.8rem;
            opacity: 0.7;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }
        
        .top-bar-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .notification-btn {
            position: relative;
            background: var(--light-color);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            transition: all 0.3s ease;
        }
        
        .notification-btn:hover {
            background: var(--gradient);
            color: white;
        }
        
        .logout-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Content Area */
        .content-area {
            padding: 30px;
        }
        
        /* Form Card */
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f3f7;
        }
        
        .form-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        /* Image Upload */
        .image-upload {
            border: 2px dashed #e9ecef;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        
        .image-upload:hover {
            border-color: var(--primary-color);
            background: rgba(67, 97, 238, 0.05);
        }
        
        .image-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .upload-icon {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 15px;
        }
        
        .upload-text {
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .upload-hint {
            color: #adb5bd;
            font-size: 0.85rem;
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
        }
        
        .current-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            margin-top: 15px;
        }
        
        /* Text Editor */
        .text-editor {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .editor-toolbar {
            background: var(--light-color);
            padding: 10px 15px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            gap: 10px;
        }
        
        .editor-btn {
            background: white;
            border: 1px solid #dee2e6;
            width: 35px;
            height: 35px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .editor-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .editor-content {
            min-height: 300px;
            padding: 15px;
            border: none;
            outline: none;
            resize: vertical;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--gradient);
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f1f3f7;
        }
        
        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        /* Character Counter */
        .char-counter {
            text-align: right;
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: var(--gradient);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
        }
        
        @media (max-width: 768px) {
            .content-area {
                padding: 20px;
            }
            
            .top-bar {
                padding: 15px 20px;
            }
            
            .page-title {
                font-size: 1.2rem;
            }
            
            .form-card {
                padding: 20px;
            }
            
            .form-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .form-actions .btn {
                width: 100%;
            }
            
            .editor-toolbar {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="bi bi-list"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="dashboard.php" class="sidebar-logo">
                <i class="bi bi-speedometer2"></i>
                <span>Admin Panel</span>
            </a>
        </div>
        <div class="sidebar-menu">
            <a href="dashboard.php" class="menu-item">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
            <a href="posts.php" class="menu-item active">
                <i class="bi bi-newspaper"></i>
                <span>Artikel</span>
            </a>
            <a href="events.php" class="menu-item">
                <i class="bi bi-calendar-event"></i>
                <span>Kegiatan</span>
            </a>
            <a href="members.php" class="menu-item">
                <i class="bi bi-people"></i>
                <span>Anggota</span>
            </a>
            <a href="messages.php" class="menu-item">
                <i class="bi bi-envelope"></i>
                <span>Pesan</span>
            </a>
            <a href="settings.php" class="menu-item">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
            </a>
        </div>
        <div class="sidebar-footer">
            <a href="#" class="user-profile">
                <div class="user-avatar">
                    <i class="bi bi-person"></i>
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['admin_name']; ?></div>
                    <div class="user-role">Administrator</div>
                </div>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h1 class="page-title">Edit Artikel</h1>
            <div class="top-bar-actions">
                <button class="notification-btn">
                    <i class="bi bi-bell"></i>
                </button>
                <a href="logout.php" class="btn logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="content-area">
            <div class="form-card">
                <div class="form-header">
                    <h2 class="form-title">Edit Informasi Artikel</h2>
                    <a href="posts.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form action="edit-post.php?id=<?php echo $post_id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="form-label">Judul Artikel</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title']; ?>" required>
                                <div class="char-counter">
                                    <span id="titleCounter"><?php echo strlen($post['title']); ?></span> / 100 karakter
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pengumuman" <?php echo ($post['category'] == 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                                    <option value="Kegiatan" <?php echo ($post['category'] == 'Kegiatan') ? 'selected' : ''; ?>>Kegiatan</option>
                                    <option value="Prestasi" <?php echo ($post['category'] == 'Prestasi') ? 'selected' : ''; ?>>Prestasi</option>
                                    <option value="Umum" <?php echo ($post['category'] == 'Umum') ? 'selected' : ''; ?>>Umum</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="author" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?php echo $post['author']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="content" class="form-label">Isi Artikel</label>
                        <div class="text-editor">
                            <div class="editor-toolbar">
                                <button type="button" class="editor-btn" data-command="bold">
                                    <i class="bi bi-type-bold"></i>
                                </button>
                                <button type="button" class="editor-btn" data-command="italic">
                                    <i class="bi bi-type-italic"></i>
                                </button>
                                <button type="button" class="editor-btn" data-command="underline">
                                    <i class="bi bi-type-underline"></i>
                                </button>
                                <button type="button" class="editor-btn" data-command="insertUnorderedList">
                                    <i class="bi bi-list-ul"></i>
                                </button>
                                <button type="button" class="editor-btn" data-command="insertOrderedList">
                                    <i class="bi bi-list-ol"></i>
                                </button>
                                <button type="button" class="editor-btn" data-command="createLink">
                                    <i class="bi bi-link-45deg"></i>
                                </button>
                                <button type="button" class="editor-btn" data-command="insertImage">
                                    <i class="bi bi-image"></i>
                                </button>
                            </div>
                            <div class="editor-content" contenteditable="true" id="content" name="content"><?php echo $post['content']; ?></div>
                        </div>
                        <div class="char-counter">
                            <span id="contentCounter"><?php echo strlen($post['content']); ?></span> karakter
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Gambar Utama</label>
                        <div class="image-upload">
                            <input type="file" id="image" name="image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-image"></i>
                            </div>
                            <div class="upload-text">Klik untuk mengganti gambar</div>
                            <div class="upload-hint">Format yang diperbolehkan: JPEG, JPG, PNG, GIF. Kosongkan jika tidak ingin mengubah gambar.</div>
                            <img id="preview" class="preview-image" alt="Preview">
                        </div>
                        <?php if (!empty($post['image'])): ?>
                            <img src="../uploads/<?php echo $post['image']; ?>" class="current-image" alt="Current Image">
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-actions">
                        <a href="posts.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Character counter
        const titleInput = document.getElementById('title');
        const titleCounter = document.getElementById('titleCounter');
        const contentDiv = document.getElementById('content');
        const contentCounter = document.getElementById('contentCounter');
        
        titleInput.addEventListener('input', function() {
            const length = this.value.length;
            titleCounter.textContent = length;
            
            if (length > 100) {
                titleCounter.style.color = '#dc3545';
            } else {
                titleCounter.style.color = '#6c757d';
            }
        });
        
        contentDiv.addEventListener('input', function() {
            const length = this.textContent.length;
            contentCounter.textContent = length;
        });
        
        // Text editor commands
        const editorBtns = document.querySelectorAll('.editor-btn');
        editorBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const command = this.dataset.command;
                
                if (command === 'createLink') {
                    const url = prompt('Masukkan URL:');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else if (command === 'insertImage') {
                    const url = prompt('Masukkan URL gambar:');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else {
                    document.execCommand(command, false, null);
                }
                
                contentDiv.focus();
            });
        });
        
        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(e.target.files[0]);
            } else {
                preview.style.display = 'none';
            }
        });
        
        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            // Copy content from editor to hidden input
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'content';
            hiddenInput.value = contentDiv.innerHTML;
            this.appendChild(hiddenInput);
        });
    </script>
</body>
</html>