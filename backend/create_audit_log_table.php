<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(255) NOT NULL,
    record_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    old_values TEXT,
    new_values TEXT,
    user_id INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table audit_log created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
