<?php
include 'config.php';

// Hash the password for security
$username = 'Physics001';
$password = password_hash('P@$$w0rd', PASSWORD_DEFAULT);
$role = 'admin';

$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    echo "Admin user inserted successfully";
} else {
    echo "Error inserting admin: " . $conn->error;
}

$conn->close();
?>
