<!-- Add closing tags for HTML structure -->
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../styles/logo.png">
    <title>Physics Terms - TermoPhysics</title>
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

// Handle Add Term
if (isset($_POST['addTerm'])) {
    $term = trim($_POST['termName']);
    $definition = trim($_POST['termDefinition']);
    $category_id = intval($_POST['termCategory']);
    if ($term !== '' && $definition !== '') {
        $stmt = $conn->prepare("INSERT INTO terms (term, definition, category_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $term, $definition, $category_id);
        if ($stmt->execute()) {
            echo '<div class=\"alert alert-success\">Term added successfully.</div>';
        } else {
            echo '<div class=\"alert alert-danger\">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }
}

// Handle Edit Term
if (isset($_POST['editTerm'])) {
    $id = intval($_POST['editId']);
    $term = trim($_POST['editName']);
    $definition = trim($_POST['editDefinition']);
    $category_id = intval($_POST['editCategory']);
    if ($term !== '' && $definition !== '') {
        $stmt = $conn->prepare("UPDATE terms SET term=?, definition=?, category_id=? WHERE id=?");
        $stmt->bind_param("ssii", $term, $definition, $category_id, $id);
        if ($stmt->execute()) {
            echo '<div class=\"alert alert-success\">Term updated successfully.</div>';
        } else {
            echo '<div class=\"alert alert-danger\">Error: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    }
}

// Handle Delete Term
if (isset($_POST['deleteTerm'])) {
    $id = intval($_POST['deleteId']);
    $stmt = $conn->prepare("DELETE FROM terms WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<div class=\"alert alert-success\">Term deleted successfully.</div>';
    } else {
        echo '<div class=\"alert alert-danger\">Error: ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

// Fetch categories for dropdown
$categories = $conn->query("SELECT id, name FROM vocabulary_categories ORDER BY name ASC");

?>
<div style="margin-left:220px; padding:20px;">
    <h1>Physics Terms</h1>
    <p>List and manage physics terms here.</p>
    <!-- Add Term Button -->
    <button class="btn btn-primary" style="margin-bottom:15px;" data-toggle="modal" data-target="#addTermModal">
        <span class="material-icons" style="vertical-align:middle;">add</span> Add Term
    </button>

    <!-- Add Term Modal -->
    <div class="modal fade" id="addTermModal" tabindex="-1" role="dialog" aria-labelledby="addTermModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTermModalLabel">Add Term</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="termName">Term</label>
                            <input type="text" class="form-control" id="termName" name="termName" required>
                        </div>
                        <div class="form-group">
                            <label for="termDefinition">Definition</label>
                            <textarea class="form-control" id="termDefinition" name="termDefinition" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="termCategory">Category</label>
                            <select class="form-control" id="termCategory" name="termCategory">
                                <option value="">Select Category</option>
                                <?php if ($categories) while ($cat = $categories->fetch_assoc()) echo '<option value="'.$cat['id'].'">'.htmlspecialchars($cat['name']).'</option>'; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="addTerm">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Fetch terms
    $result = $conn->query("SELECT t.id, t.term, t.definition, t.created_at, c.name as category, t.category_id FROM terms t LEFT JOIN vocabulary_categories c ON t.category_id = c.id ORDER BY t.created_at DESC");
    if ($result && $result->num_rows > 0) {
        echo '<div class=\"card\" style=\"box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-top:20px;\">';
        echo '<div class=\"card-header bg-primary text-white\"><h4 class=\"mb-0\">Terms List</h4></div>';
        echo '<div class=\"card-body p-0\">';
        echo '<table class="table table-hover table-striped table-bordered mb-0">';
        echo '<thead class=\"thead-dark\"><tr><th>ID</th><th>Term</th><th>Definition</th><th>Category</th><th>Created At</th><th>Actions</th></tr></thead><tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['term']) . '</td>';
            echo '<td>' . htmlspecialchars($row['definition']) . '</td>';
            echo '<td>' . htmlspecialchars($row['category']) . '</td>';
            echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
            echo '<td>';
            // Edit button
            echo '<button type="button" class="btn btn-sm btn-warning mr-1" data-toggle="modal" data-target="#editTermModal' . $row['id'] . '"><span class="material-icons" style="font-size:16px;vertical-align:middle;">edit</span></button> ';
            // Delete button
            echo '<form method="post" action="" style="display:inline;">';
            echo '<input type="hidden" name="deleteId" value="' . $row['id'] . '">';
            echo '<button type="submit" name="deleteTerm" class="btn btn-sm btn-danger ml-1" onclick="return confirm(\'Are you sure you want to delete this term?\');"><span class="material-icons" style="font-size:16px;vertical-align:middle;">delete</span></button>';
            echo '</form>';
            // Edit Modal
            echo '<div class="modal fade" id="editTermModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editTermModalLabel' . $row['id'] . '" aria-hidden="true">';
            echo '<div class="modal-dialog" role="document">';
            echo '<div class="modal-content">';
            echo '<form method="post" action="">';
            echo '<div class="modal-header bg-primary text-white">';
            echo '<h5 class="modal-title" id="editTermModalLabel' . $row['id'] . '">Edit Term</h5>';
            echo '<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<div class="form-group">';
            echo '<label for="editName' . $row['id'] . '">Term</label>';
            echo '<input type="text" class="form-control" id="editName' . $row['id'] . '" name="editName" value="' . htmlspecialchars($row['term']) . '" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="editDefinition' . $row['id'] . '">Definition</label>';
            echo '<textarea class="form-control" id="editDefinition' . $row['id'] . '" name="editDefinition" rows="3" required>' . htmlspecialchars($row['definition']) . '</textarea>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="editCategory' . $row['id'] . '">Category</label>';
            echo '<select class="form-control" id="editCategory' . $row['id'] . '" name="editCategory">';
            echo '<option value="">Select Category</option>';
            $catRes = $conn->query("SELECT id, name FROM vocabulary_categories ORDER BY name ASC");
            if ($catRes) {
                while ($cat = $catRes->fetch_assoc()) {
                    echo '<option value="'.$cat['id'].'"'.($cat['id']==$row['category_id']?' selected':'').'>'.htmlspecialchars($cat['name']).'</option>';
                }
            }
            echo '</select>';
            echo '</div>';
            echo '<input type="hidden" name="editId" value="' . $row['id'] . '">';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
            echo '<button type="submit" class="btn btn-primary" name="editTerm">Save Changes</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div></div>';
    } else {
        echo '<p style=\"margin-top:20px;\">No terms found.</p>';
    }
    $conn->close();
    ?>
</div>
<!-- JS dependencies for Bootstrap modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
