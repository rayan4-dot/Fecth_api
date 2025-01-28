<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "kudo";

// Get the POST data
$user_id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update query
$sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameters to prevent SQL injection
    $stmt->bind_param("ssi", $name, $email, $user_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "User updated successfully";
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
