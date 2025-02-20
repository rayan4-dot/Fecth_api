<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "kudo";


$user_id = $_GET['id'];


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {

    $stmt->bind_param("i", $user_id);


    if ($stmt->execute()) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); 
} else {
    echo "Error preparing statement: " . $conn->error;
}


$conn->close();
?>
