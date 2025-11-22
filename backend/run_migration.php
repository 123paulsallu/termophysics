<?php
include 'config.php';

// Add profile_photo column to users table if it doesn't exist
$check = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'profile_photo'");

if ($check && $check->num_rows == 0) {
    $sql = "ALTER TABLE users ADD COLUMN profile_photo VARCHAR(500) NULL AFTER role";
    if ($conn->query($sql) === TRUE) {
        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 4px; margin: 20px;'>";
        echo "<h3>✓ Success!</h3>";
        echo "<p><strong>Column 'profile_photo' has been successfully added to the users table.</strong></p>";
        echo "<p>You can now upload profile photos in Settings.</p>";
        echo "<p><a href='pages/settings.php' style='color: #155724; text-decoration: underline;'>Go to Settings →</a></p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 4px; margin: 20px;'>";
        echo "<h3>✗ Error</h3>";
        echo "<p>Error adding column: " . $conn->error . "</p>";
        echo "</div>";
    }
} else {
    echo "<div style='background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 4px; margin: 20px;'>";
    echo "<h3>ℹ Info</h3>";
    echo "<p><strong>Column 'profile_photo' already exists in the users table.</strong></p>";
    echo "<p>You can now upload profile photos in Settings.</p>";
    echo "<p><a href='pages/settings.php' style='color: #0c5460; text-decoration: underline;'>Go to Settings →</a></p>";
    echo "</div>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Migration - TermoPhysics</title>
    <style>
        body {
            font-family: 'Quicksand', Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #003366;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>TermoPhysics - Database Migration</h1>
        <?php // Content is inserted above ?>
    </div>
</body>
</html>
