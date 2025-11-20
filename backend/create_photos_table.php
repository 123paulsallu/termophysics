<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    path VARCHAR(500),
    category_id INT,
    video_id INT,
    term_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES vocabulary_categories(id),
    FOREIGN KEY (video_id) REFERENCES videos(id),
    FOREIGN KEY (term_id) REFERENCES terms(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table photos created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
