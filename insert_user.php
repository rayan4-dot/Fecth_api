<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "kudo";

// Get the POST data
$name = $_POST['name'];
$email = $_POST['email'];

// Handle image upload
$target_dir = "uploads/"; // Directory where the images will be stored
$image = $_FILES['image'];
$image_name = basename($image['name']);
$target_file = $target_dir . $image_name;

// Validate the image (optional but recommended)
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$image_type = mime_content_type($image['tmp_name']);

// Check if the uploaded file is a valid image type
if (!in_array($image_type, $allowed_types)) {
    echo "Error: Only JPG, PNG, and GIF images are allowed.";
    exit;
}

// Check the file size (optional: you can adjust this limit)
if ($image['size'] > 5000000) { // Limit image size to 5MB
    echo "Error: Image is too large.";
    exit;
}

// Try to move the uploaded image to the target directory
if (move_uploaded_file($image['tmp_name'], $target_file)) {
    echo "Image uploaded successfully.";
} else {
    echo "Error: There was an issue uploading the image.";
    exit;
}

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert query to store user info and image path
$sql = "INSERT INTO users (name, email, image) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameters to prevent SQL injection
    $stmt->bind_param("sss", $name, $email, $target_file);

    // Execute the query
    if ($stmt->execute()) {
        header("Location: index.html"); // Redirect to the users list
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
