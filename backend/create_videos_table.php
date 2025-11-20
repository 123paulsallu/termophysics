<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(500),
    category_id INT,
    term_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES vocabulary_categories(id),
    FOREIGN KEY (term_id) REFERENCES terms(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table videos created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
