<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "kudo";

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query to fetch all users
$sql = "SELECT id, name, email, image FROM users";
$result = $conn->query($sql);

if ($result) {
    $users = $result->fetch_all(MYSQLI_ASSOC);

    // Return data as JSON
    echo json_encode($users);
} else {
    echo json_encode(['message' => 'Error: ' . $conn->error]);
}

// Close the connection
$conn->close();
?>
