<!-- Add closing tags for HTML structure -->
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../styles/logo.png">
    <title>Physics Photos - TermoPhysics</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/quicksand.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Italiana', serif; }
        .sidebar-dark-primary { background-color: #003366 !important; }
        .brand-link { background-color: #003366 !important; }
        .nav-link { color: #BD8C2A !important; }
        .nav-link:hover { background-color: #BD8C2A !important; color: #003366 !important; }
        .material-icons.nav-icon { color: #BD8C2A; }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var treeviewLinks = document.querySelectorAll('.has-treeview > a');
        treeviewLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var parent = link.parentElement;
                parent.classList.toggle('menu-open');
                var submenu = parent.querySelector('.nav-treeview');
                if (submenu) {
                    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                }
            });
        });
        // Ensure only the active submenu is open
        document.querySelectorAll('.has-treeview .nav-link').forEach(function(link) {
            if (link.classList.contains('active')) {
                var parent = link.closest('.has-treeview');
                if (parent) {
                    parent.classList.add('menu-open');
                    var submenu = parent.querySelector('.nav-treeview');
                    if (submenu) submenu.style.display = 'block';
                }
            }
        });
    });
</script>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="../styles/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TermoPhysics</span>
    </a>
    <div class="sidebar-user-panel text-center py-3" style="background:#003366;color:#BD8C2A;">
        <div style="font-size:1.1em;font-weight:bold;">
            <?php session_start(); echo htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : ''); ?>
        </div>
        <div style="font-size:0.95em;">Role: <?php echo htmlspecialchars(isset($_SESSION['role']) ? $_SESSION['role'] : ''); ?></div>
    </div>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="users.php" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-atom"></i>
                        <p>
                            Physics Terms
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="margin-left:20px;">
                        <li class="nav-item">
                            <a href="vocabulary_categories.php" class="nav-link">
                                <span class="material-icons nav-icon" style="vertical-align:middle;">category</span>
                                <p style="display:inline; margin-left:8px;">Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="videos.php" class="nav-link">
                                <span class="material-icons nav-icon" style="vertical-align:middle;">video_library</span>
                                <p style="display:inline; margin-left:8px;">Videos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="photos.php" class="nav-link">
                                <span class="material-icons nav-icon" style="vertical-align:middle;">photo_library</span>
                                <p style="display:inline; margin-left:8px;">Photos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="terms.php" class="nav-link">
                                <span class="material-icons nav-icon" style="vertical-align:middle;">description</span>
                                <p style="display:inline; margin-left:8px;">Terms</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="settings.php" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<?php
include '../config.php';

// Handle Add Photo
if (isset($_POST['addPhoto'])) {
    $category_id = intval($_POST['photoCategory']);
    $video_id = intval($_POST['photoVideo']);
    $term_id = intval($_POST['photoTerm']);
    $filename = '';
    $path = '';
    if (isset($_FILES['photoFile']) && $_FILES['photoFile']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/photos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = basename($_FILES['photoFile']['name']);
        $targetFile = $uploadDir . time() . '_' . $fileName;
        if (move_uploaded_file($_FILES['photoFile']['tmp_name'], $targetFile)) {
            $filename = $fileName;
            $path = $targetFile;
        }
    }
    if ($filename !== '' && $path !== '') {
        $stmt = $conn->prepare("INSERT INTO photos (filename, path, category_id, video_id, term_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiii", $filename, $path, $category_id, $video_id, $term_id);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Photo added successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }
}

// Fetch categories, videos, terms for dropdowns
$categories = $conn->query("SELECT id, name FROM vocabulary_categories ORDER BY name ASC");
$videos = $conn->query("SELECT id, title FROM videos ORDER BY title ASC");
$terms = $conn->query("SELECT id, term FROM terms ORDER BY term ASC");

?>
<div style="margin-left:220px; padding:20px;">
    <h1>Physics Photos</h1>
    <p>List and manage physics-related photos here.</p>
    <!-- Add Photo Button -->
    <button class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#addPhotoModal">
        <span class="material-icons" style="vertical-align:middle;">add_a_photo</span> Add Photo
    </button>

    <!-- Add Photo Modal -->
    <div class="modal fade" id="addPhotoModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPhotoModalLabel">Add Photo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="photoFile">Photo File</label>
                            <input type="file" class="form-control" id="photoFile" name="photoFile" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="photoCategory">Category</label>
                            <select class="form-control" id="photoCategory" name="photoCategory">
                                <option value="">Select Category</option>
                                <?php if ($categories) while ($cat = $categories->fetch_assoc()) echo '<option value="'.$cat['id'].'">'.htmlspecialchars($cat['name']).'</option>'; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photoVideo">Video</label>
                            <select class="form-control" id="photoVideo" name="photoVideo">
                                <option value="">Select Video</option>
                                <?php if ($videos) while ($vid = $videos->fetch_assoc()) echo '<option value="'.$vid['id'].'">'.htmlspecialchars($vid['title']).'</option>'; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photoTerm">Term</label>
                            <select class="form-control" id="photoTerm" name="photoTerm">
                                <option value="">Select Term</option>
                                <?php if ($terms) while ($term = $terms->fetch_assoc()) echo '<option value="'.$term['id'].'">'.htmlspecialchars($term['term']).'</option>'; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="addPhoto">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Fetch photos
    $result = $conn->query("SELECT p.id, p.filename, p.path, p.created_at, c.name as category, v.title as video, t.term as term FROM photos p LEFT JOIN vocabulary_categories c ON p.category_id = c.id LEFT JOIN videos v ON p.video_id = v.id LEFT JOIN terms t ON p.term_id = t.id ORDER BY p.created_at DESC");
    if ($result && $result->num_rows > 0) {
        echo '<table class="table table-bordered" style="background:#fff; margin-top:20px;">';
        echo '<thead><tr><th>ID</th><th>Filename</th><th>Preview</th><th>Category</th><th>Video</th><th>Term</th><th>Created At</th></tr></thead><tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['filename']) . '</td>';
            echo '<td>';
            if (!empty($row['path'])) {
                echo '<a href="' . htmlspecialchars($row['path']) . '" target="_blank"><img src="' . htmlspecialchars($row['path']) . '" alt="Photo" style="max-width:80px;max-height:80px;"/></a>';
            } else {
                echo 'No file';
            }
            echo '</td>';
            echo '<td>' . htmlspecialchars($row['category']) . '</td>';
            echo '<td>' . htmlspecialchars($row['video']) . '</td>';
            echo '<td>' . htmlspecialchars($row['term']) . '</td>';
            echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p style="margin-top:20px;">No photos found.</p>';
    }
    $conn->close();
    ?>
</div>
<!-- JS dependencies for Bootstrap modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
