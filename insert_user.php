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

// Create connection using PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert query to store user info and image path
    $sql = "INSERT INTO users (name, email, image) VALUES (:name, :email, :image)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':image', $target_file); // Store the path of the uploaded image

    // Execute the query
    $stmt->execute();

    header("Location: index.html"); // Redirect to the users list
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>
