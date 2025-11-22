<?php
include 'config.php';

// Add file_path column to videos table if it doesn't exist
$check = $conn->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'videos' AND COLUMN_NAME = 'file_path'");
if ($check && $check->num_rows == 0) {
    $sql = "ALTER TABLE videos ADD COLUMN file_path VARCHAR(500) NULL";
    if ($conn->query($sql) === TRUE) {
        echo "Column file_path added to videos table successfully.";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} else {
    echo "Column file_path already exists or couldn't check.";
}

$conn->close();
?>