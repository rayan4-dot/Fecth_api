<?php
$servername = "localhost";
$username = "root";   
$password = "";     
$dbname = "kudo";

// get POST data
$user_id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // bind parameters to prevent sql injection
    $stmt->bind_param("ssi", $name, $email, $user_id);

    // execute the query
    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // close statement
} else {
    echo "Error preparing statement: " . $conn->error;
}


$conn->close();
?>
