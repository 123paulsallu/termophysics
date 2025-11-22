<!-- Add closing tags for HTML structure -->
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../styles/logo.png">
    <title>Physics Videos - TermoPhysics</title>
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

// Handle Add Video
if (isset($_POST['addVideo'])) {
    $title = trim($_POST['videoTitle']);
    $url = trim($_POST['videoUrl']);
    $category_id = intval($_POST['videoCategory']);
    $term_id = intval($_POST['videoTerm']);
    if ($title !== '' && $url !== '') {
        $stmt = $conn->prepare("INSERT INTO videos (title, url, category_id, term_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $url, $category_id, $term_id);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Video added successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }
}

// Handle Edit Video
if (isset($_POST['editVideo'])) {
        $id = intval($_POST['editId']);
        $title = trim($_POST['editTitle']);
        $url = trim($_POST['editUrl']);
        $category_id = intval($_POST['editCategory']);
        $term_id = intval($_POST['editTerm']);
        if ($title !== '' && $url !== '') {
                $stmt = $conn->prepare("UPDATE videos SET title=?, url=?, category_id=?, term_id=? WHERE id=?");
                $stmt->bind_param("ssiii", $title, $url, $category_id, $term_id, $id);
                if ($stmt->execute()) {
                        echo '<div class="alert alert-success">Video updated successfully.</div>';
                } else {
                        echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
                }
                $stmt->close();
        }
}

// Handle Delete Video
if (isset($_POST['deleteVideo'])) {
        $id = intval($_POST['deleteId']);
        $stmt = $conn->prepare("DELETE FROM videos WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
                echo '<div class="alert alert-success">Video deleted successfully.</div>';
        } else {
                echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
}

// Fetch categories and terms for dropdowns
$categories = $conn->query("SELECT id, name FROM vocabulary_categories ORDER BY name ASC");
$terms = $conn->query("SELECT id, term FROM terms ORDER BY term ASC");

?>
<div style="margin-left:220px; padding:20px;">
        <h1>Physics Videos</h1>
        <p>List and manage physics-related videos here.</p>
        <!-- Add Video Button -->
        <button class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#addVideoModal">
                <span class="material-icons" style="vertical-align:middle;">add</span> Add Video
        </button>

        <!-- Add Video Modal -->
        <div class="modal fade" id="addVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addVideoModalLabel">Add Video</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="videoTitle">Title</label>
                                <input type="text" class="form-control" id="videoTitle" name="videoTitle" required>
                            </div>
                            <div class="form-group">
                                <label for="videoUrl">YouTube URL</label>
                                <input type="url" class="form-control" id="videoUrl" name="videoUrl" placeholder="https://www.youtube.com/watch?v=..." required>
                            </div>
                            <div class="form-group">
                                <label for="videoCategory">Category</label>
                                <select class="form-control" id="videoCategory" name="videoCategory">
                                    <option value="">Select Category</option>
                                    <?php if ($categories) while ($cat = $categories->fetch_assoc()) echo '<option value="'.$cat['id'].'">'.htmlspecialchars($cat['name']).'</option>'; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="videoTerm">Term</label>
                                <select class="form-control" id="videoTerm" name="videoTerm">
                                    <option value="">Select Term</option>
                                    <?php if ($terms) while ($term = $terms->fetch_assoc()) echo '<option value="'.$term['id'].'">'.htmlspecialchars($term['term']).'</option>'; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="addVideo">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        // Fetch videos
        $result = $conn->query("SELECT v.id, v.title, v.url, v.created_at, c.name as category, t.term as term FROM videos v LEFT JOIN vocabulary_categories c ON v.category_id = c.id LEFT JOIN terms t ON v.term_id = t.id ORDER BY v.created_at DESC");
        if ($result && $result->num_rows > 0) {
                echo '<table class="table table-bordered" style="background:#fff; margin-top:20px;">';
                echo '<thead><tr><th>ID</th><th>Title</th><th>URL</th><th>Category</th><th>Term</th><th>Created At</th><th>Actions</th></tr></thead><tbody>';
                while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                        echo '<td>';
                        if (!empty($row['url'])) {
                            $rawUrl = $row['url'];
                            if (strpos($rawUrl, 'youtube.com') !== false || strpos($rawUrl, 'youtu.be') !== false) {
                                $videoId = '';
                                if (preg_match('/v=([A-Za-z0-9_-]+)/', $rawUrl, $m)) {
                                    $videoId = $m[1];
                                } elseif (preg_match('#youtu\.be/([A-Za-z0-9_-]+)#', $rawUrl, $m)) {
                                    $videoId = $m[1];
                                }
                                if ($videoId !== '') {
                                    $embed = 'https://www.youtube.com/embed/' . $videoId;
                                    echo '<a href="' . htmlspecialchars($rawUrl) . '" target="_blank">Watch</a><br>';
                                    echo '<iframe width="200" height="113" src="' . htmlspecialchars($embed) . '" frameborder="0" allowfullscreen></iframe>';
                                } else {
                                    echo '<a href="' . htmlspecialchars($rawUrl) . '" target="_blank">Watch</a>';
                                }
                            } else {
                                echo '<a href="' . htmlspecialchars($rawUrl) . '" target="_blank">Open link</a>';
                            }
                        } else {
                            echo 'No URL';
                        }
                        echo '</td>';
                        echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['term']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                        echo '<td>';
                        // Edit button
                        echo '<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editVideoModal' . $row['id'] . '"><span class="material-icons" style="font-size:16px;vertical-align:middle;">edit</span></button> ';
                        // Delete button
                        echo '<form method="post" action="" style="display:inline;">
                                        <input type="hidden" name="deleteId" value="' . $row['id'] . '">
                                        <button type="submit" name="deleteVideo" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this video?\');"><span class="material-icons" style="font-size:16px;vertical-align:middle;">delete</span></button>
                                    </form>';
                        // Edit Modal
                        echo '<div class="modal fade" id="editVideoModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel' . $row['id'] . '" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editVideoModalLabel' . $row['id'] . '">Edit Video</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="editTitle' . $row['id'] . '">Title</label>
                                                            <input type="text" class="form-control" id="editTitle' . $row['id'] . '" name="editTitle" value="' . htmlspecialchars($row['title']) . '" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editUrl' . $row['id'] . '">Video URL</label>
                                                            <input type="text" class="form-control" id="editUrl' . $row['id'] . '" name="editUrl" value="' . htmlspecialchars($row['url']) . '" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editCategory' . $row['id'] . '">Category</label>
                                                            <select class="form-control" id="editCategory' . $row['id'] . '" name="editCategory">
                                                                <option value="">Select Category</option>
                                                                ';
                                                                $catRes = $conn->query("SELECT id, name FROM vocabulary_categories ORDER BY name ASC");
                                                                if ($catRes) {
                                                                        while ($cat = $catRes->fetch_assoc()) {
                                                                                echo '<option value="'.$cat['id'].'"'.($cat['id']==$row['category']?' selected':'').'>'.htmlspecialchars($cat['name']).'</option>';
                                                                        }
                                                                }
                                                                echo '
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editTerm' . $row['id'] . '">Term</label>
                                                            <select class="form-control" id="editTerm' . $row['id'] . '" name="editTerm">
                                                                <option value="">Select Term</option>
                                                                ';
                                                                $termRes = $conn->query("SELECT id, term FROM terms ORDER BY term ASC");
                                                                if ($termRes) {
                                                                        while ($term = $termRes->fetch_assoc()) {
                                                                                echo '<option value="'.$term['id'].'"'.($term['id']==$row['term']?' selected':'').'>'.htmlspecialchars($term['term']).'</option>';
                                                                        }
                                                                }
                                                                echo '
                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="editId" value="' . $row['id'] . '">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary" name="editVideo">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>';
                        echo '</td>';
                        echo '</tr>';
                }
                echo '</tbody></table>';
        } else {
                echo '<p style="margin-top:20px;">No videos found.</p>';
        }
        $conn->close();
        ?>
    <!-- JS dependencies for Bootstrap modal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
