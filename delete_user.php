<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "kudo";

// Get the user ID from the URL (GET request)
$user_id = $_GET['id'];

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete query
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameter to prevent SQL injection
    $stmt->bind_param("i", $user_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close statement
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close connection
$conn->close();
?>
