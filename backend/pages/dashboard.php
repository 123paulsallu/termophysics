<?php
session_start();
// Only allow access if user is admin and credentials match
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
// Get statistics
// Double check credentials in DB for admin
$user_id = intval($_SESSION['user_id']);
$result = $conn->query("SELECT id, username, role FROM users WHERE id = $user_id AND role = 'admin'");
if (!$result || $result->num_rows === 0) {
    // Not a valid admin
    header('Location: ../index.php');
    exit();
}
$user = $result->fetch_assoc();

// Try to fetch profile photo if column exists
$checkCol = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'profile_photo'");
if ($checkCol && $checkCol->num_rows > 0) {
    $photoRes = $conn->query("SELECT profile_photo FROM users WHERE id = $user_id");
    if ($photoRes && $photoRes->num_rows > 0) {
        $photoData = $photoRes->fetch_assoc();
        $user['profile_photo'] = $photoData['profile_photo'];
    }
}
$user_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$category_count = $conn->query("SELECT COUNT(*) as count FROM vocabulary_categories")->fetch_assoc()['count'];
$term_count = $conn->query("SELECT COUNT(*) as count FROM terms")->fetch_assoc()['count'];
$video_count = $conn->query("SELECT COUNT(*) as count FROM videos")->fetch_assoc()['count'];
$photo_count = $conn->query("SELECT COUNT(*) as count FROM photos")->fetch_assoc()['count'];
$log_count = $conn->query("SELECT COUNT(*) as count FROM audit_log")->fetch_assoc()['count'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../styles/logo.png">
    <title>Admin Dashboard - TermoPhysics</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Italiana&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/quicksand.css"> <!-- Assuming you have a CSS file for Quicksand -->
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
        document.getElementById('toggle-mode').addEventListener('click', function() {
            document.body.classList.toggle('light-mode');
        });
    </script>
    <style>
        body { font-family: 'Quicksand', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Italiana', serif; }
        .small-box { transition: transform 0.3s ease; background-color: #BD8C2A !important; color: #003366 !important; }
        .small-box:hover { transform: scale(1.05); }
        .sidebar-dark-primary { background-color: #003366 !important; }
        .brand-link { background-color: #003366 !important; }
        .nav-link { color: #BD8C2A !important; }
        .nav-link:hover { background-color: #BD8C2A !important; color: #003366 !important; }
        .light-mode { background-color: #f8f9fa; color: #003366; }
        .light-mode .small-box { background-color: #BD8C2A !important; color: #003366 !important; }
        .light-mode .sidebar-dark-primary { background-color: #003366 !important; }
        .light-mode .brand-link { background-color: #003366 !important; }
        .light-mode .nav-link { color: #BD8C2A !important; }
        .light-mode .nav-link:hover { background-color: #BD8C2A !important; color: #003366 !important; }
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
                 <a href="settings.php"><img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile" style="width:60px; height:60px; border-radius:50%; object-fit:cover; margin-bottom:10px; cursor:pointer;"></a>
             <?php else: ?>
                 <a href="settings.php" style="display:block; margin-bottom:10px;">
                     <div style="width:60px; height:60px; border-radius:50%; background:#BD8C2A; margin:0 auto; display:flex; align-items:center; justify-content:center; cursor:pointer;">
                         <i class="fas fa-user" style="font-size:30px; color:#003366;"></i>
                     </div>
                 </a>
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
                         <a href="dashboard.php" class="nav-link active">
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

    <!-- Content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
                <!-- Add dashboard widgets here -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $user_count; ?></h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $category_count; ?></h3>
                                <p>Total Vocabulary Categories</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $term_count; ?></h3>
                                <p>Total Terms</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-document-text"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo $video_count; ?></h3>
                                <p>Total Videos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-videocamera"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3><?php echo $photo_count; ?></h3>
                                <p>Audit Total Photos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-images"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3><?php echo $log_count; ?></h3>
                                <p>Audit Logs</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
</body>
</html>
