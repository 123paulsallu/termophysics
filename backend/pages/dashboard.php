<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
include '../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; }
        .sidebar { width: 200px; background: #333; color: white; padding: 20px; height: 100vh; }
        .sidebar h2 { margin-top: 0; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar li { margin: 10px 0; }
        .sidebar a { color: white; text-decoration: none; }
        .content { flex: 1; padding: 20px; }
    </style>
</head>
<body>
    <?php include '../components/sidebar.php'; ?>
    <div class="content">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <!-- Add dashboard content here -->
    </div>
</body>
</html>
