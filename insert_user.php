<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "kudo";

// get the POST data
$name = $_POST['name'];
$email = $_POST['email'];

// handle image upload
$target_dir = "uploads/"; // directory where  images will be stored
$image = $_FILES['image'];
$image_name = basename($image['name']);
$target_file = $target_dir . $image_name;

// image validation
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$image_type = mime_content_type($image['tmp_name']);
if (!in_array($image_type, $allowed_types)) {
    echo "Error: Only JPG, PNG, and GIF images are allowed.";
    exit;
}

//  file size vaalidation
if ($image['size'] > 5000000) { // limit image size to 5MB
    echo "Error: Image is too large.";
    exit;
}

//   move the uploaded image to the target directory
if (move_uploaded_file($image['tmp_name'], $target_file)) {
    echo "Image uploaded successfully.";
} else {
    echo "Error: There was an issue uploading the image.";
    exit;
}

// create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "INSERT INTO users (name, email, image) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // bind parameters to prevent sql injection
    $stmt->bind_param("sss", $name, $email, $target_file);

    // execute the query
    if ($stmt->execute()) {
        header("Location: index.html"); // redirect to the users list
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // close statement
} else {
    echo "Error preparing statement: " . $conn->error;
}

// close connection
$conn->close();
?>
