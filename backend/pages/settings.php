<?php
session_start();
include '../config.php';

// Only allow access if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$user_id = intval($_SESSION['user_id']);
$message = '';
$error = '';

// Handle profile photo upload
if (isset($_POST['uploadPhoto'])) {
    if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = basename($_FILES['profilePhoto']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExt, $allowedExts)) {
            $targetFile = $uploadDir . $user_id . '_' . time() . '.' . $fileExt;
            if (move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $targetFile)) {
                // Check if profile_photo column exists before updating
                $checkCol = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'profile_photo'");
                if ($checkCol && $checkCol->num_rows > 0) {
                    $stmt = $conn->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
                    $stmt->bind_param("si", $targetFile, $user_id);
                    if ($stmt->execute()) {
                        $_SESSION['profile_photo'] = $targetFile;
                        $message = "Profile photo uploaded successfully.";
                    } else {
                        $error = "Error updating profile photo: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $message = "Photo uploaded but database column doesn't exist yet. Run migration first.";
                }
            } else {
                $error = "Error uploading file.";
            }
        } else {
            $error = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        $error = "Please select a file to upload.";
    }
}

// Handle profile details update
if (isset($_POST['updateDetails'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if ($username !== '') {
        if ($password !== '') {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssi", $username, $hashed, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
            $stmt->bind_param("si", $username, $user_id);
        }
        
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $message = "Profile details updated successfully.";
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Username is required.";
    }
}

// Fetch current user details
$profilePhotoCol = '';
$checkCol = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'profile_photo'");
if ($checkCol && $checkCol->num_rows > 0) {
    $profilePhotoCol = ', profile_photo';
}
$result = $conn->query("SELECT id, username, role" . $profilePhotoCol . " FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../styles/logo.png">
    <title>Settings - TermoPhysics</title>
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/quicksand.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Italiana', serif; }
        .sidebar-dark-primary { background-color: #003366 !important; }
        .brand-link { background-color: #003366 !important; }
        .nav-link { color: #BD8C2A !important; }
        .nav-link:hover { background-color: #BD8C2A !important; color: #003366 !important; }
        .material-icons.nav-icon { color: #BD8C2A; }
        .profile-photo { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 3px solid #BD8C2A; }
        .profile-section { text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px; margin-bottom: 20px; }
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
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="../styles/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">TermoPhysics</span>
        </a>
        <div class="sidebar-user-panel text-center py-3" style="background:#003366;color:#BD8C2A;">
            <?php if (!empty($user['profile_photo']) && file_exists($user['profile_photo'])): ?>
                <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile" style="width:60px; height:60px; border-radius:50%; object-fit:cover; margin-bottom:10px;">
            <?php else: ?>
                <div style="width:60px; height:60px; border-radius:50%; background:#BD8C2A; margin:0 auto 10px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-user" style="font-size:30px; color:#003366;"></i>
                </div>
            <?php endif; ?>
            <div style="font-size:1.1em;font-weight:bold;"><?php echo htmlspecialchars($user['username']); ?></div>
            <div style="font-size:0.95em;">Role: <?php echo htmlspecialchars($user['role']); ?></div>
        </div>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
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
                        <a href="settings.php" class="nav-link active">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Settings</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title">Profile Settings</h3>
                            </div>
                            <div class="card-body">
                                <!-- Profile Photo Section -->
                                <div class="profile-section">
                                    <h4>Profile Photo</h4>
                                    <?php if (!empty($user['profile_photo']) && file_exists($user['profile_photo'])): ?>
                                        <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile" class="profile-photo mb-3">
                                    <?php else: ?>
                                        <div style="width:150px; height:150px; border-radius:50%; background:#BD8C2A; margin:0 auto 15px; display:flex; align-items:center; justify-content:center; border:3px solid #BD8C2A;">
                                            <i class="fas fa-user" style="font-size:60px; color:#003366;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="file" class="form-control" id="profilePhoto" name="profilePhoto" accept="image/*" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="uploadPhoto">
                                            <i class="fas fa-upload"></i> Upload Photo
                                        </button>
                                    </form>
                                </div>

                                <!-- Profile Details Section -->
                                <div class="card-body border-top">
                                    <h4>Personal Details</h4>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password (leave blank to keep unchanged)</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password if you want to change it">
                                        </div>
                                        <button type="submit" class="btn btn-success" name="updateDetails">
                                            <i class="fas fa-save"></i> Save Changes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h3 class="card-title">Account Information</h3>
                            </div>
                            <div class="card-body">
                                <p><strong>User ID:</strong> <?php echo $user['id']; ?></p>
                                <p><strong>Role:</strong> <?php echo ucfirst($user['role']); ?></p>
                                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2025 TermoPhysics.</strong> All rights reserved.
    </footer>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
