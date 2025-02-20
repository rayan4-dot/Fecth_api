<?php
$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "kudo";

// create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

// fetch all users
$sql = "SELECT id, name, email, image FROM users";
$result = $conn->query($sql);

if ($result) {
    $users = $result->fetch_all(MYSQLI_ASSOC);

    // return data as JSON
    echo json_encode($users);
} else {
    echo json_encode(['message' => 'Error: ' . $conn->error]);
}


$conn->close();
?>
