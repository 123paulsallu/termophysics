<?php
include '../config.php';

// Handle Add Category
if (isset($_POST['addCategory'])) {
    $name = trim($_POST['categoryName']);
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO vocabulary_categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Category added successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }
}

// Handle Edit Category
if (isset($_POST['editCategory'])) {
    $id = intval($_POST['editId']);
    $name = trim($_POST['editName']);
    if ($name !== '') {
        $stmt = $conn->prepare("UPDATE vocabulary_categories SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $id);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Category updated successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }
}

// Handle Delete Category
if (isset($_POST['deleteCategory'])) {
    $id = intval($_POST['deleteId']);
    $stmt = $conn->prepare("DELETE FROM vocabulary_categories WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Category deleted successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../styles/logo.png">
    <title>Physics Term Categories - TermoPhysics</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/quicksand.css">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
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
<!-- jQuery and Bootstrap JS for modal functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
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
<div style="margin-left:220px; padding:20px;">
        <h1>Physics Term Categories</h1>
        <p>List and manage categories for physics terms here.</p>
        <!-- Add Category Button -->
        <button class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#addCategoryModal">
                <span class="material-icons" style="vertical-align:middle;">add</span> Add Category
        </button>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">Add Vocabulary Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="categoryName">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="addCategory">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        // Fetch categories
        $result = $conn->query("SELECT id, name, created_at FROM vocabulary_categories ORDER BY created_at DESC");
        if ($result && $result->num_rows > 0) {
            echo '<table class="table table-bordered" style="background:#fff; margin-top:20px;">';
            echo '<thead><tr><th>ID</th><th>Name</th><th>Created At</th><th>Actions</th></tr></thead><tbody>';
            while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
            echo '<td>';
            // Edit button
            echo '<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editCategoryModal' . $row['id'] . '"><span class="material-icons" style="font-size:16px;vertical-align:middle;">edit</span></button> ';
            // Delete button
            echo '<form method="post" action="" style="display:inline;">
                <input type="hidden" name="deleteId" value="' . $row['id'] . '">
                <button type="submit" name="deleteCategory" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this category?\');"><span class="material-icons" style="font-size:16px;vertical-align:middle;">delete</span></button>
                  </form>';
            // Edit Modal
            echo '<div class="modal fade" id="editCategoryModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel' . $row['id'] . '" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <form method="post" action="">
                      <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel' . $row['id'] . '">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                      </div>
                      <div class="modal-body">
                    <div class="form-group">
                      <label for="editName' . $row['id'] . '">Category Name</label>
                      <input type="text" class="form-control" id="editName' . $row['id'] . '" name="editName" value="' . htmlspecialchars($row['name']) . '" required>
                      <input type="hidden" name="editId" value="' . $row['id'] . '">
                    </div>
                      </div>
                      <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="editCategory">Save Changes</button>
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
            echo '<p style="margin-top:20px;">No categories found.</p>';
        }
        $conn->close();
        ?>
</div>
