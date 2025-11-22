<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS vocabulary_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "Table vocabulary_categories created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
