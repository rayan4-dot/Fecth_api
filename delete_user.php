<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "kudo";

// Get the user ID from the URL (GET request)
$user_id = $_GET['id'];

try {
    // Create connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete query
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);

    // Bind parameter to prevent SQL injection
    $stmt->bindParam(':id', $user_id);

    // Execute the query
    $stmt->execute();

    echo "User deleted successfully";
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>
