<?php
include 'config.php';

// Add profile_photo column to users table if it doesn't exist
$check = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'profile_photo'");
if ($check && $check->num_rows == 0) {
    $sql = "ALTER TABLE users ADD COLUMN profile_photo VARCHAR(500) NULL";
    if ($conn->query($sql) === TRUE) {
        echo "Column profile_photo added to users table successfully.";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} else {
    echo "Column profile_photo already exists or couldn't check.";
}

$conn->close();
?>
