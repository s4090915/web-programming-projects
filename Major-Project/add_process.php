<?php
require('includes/db_connect.inc'); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petname = $_POST['petname'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $caption = $_POST['caption'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $username = $_SESSION['username']; // Assume user is logged in and session contains username

    // Handle the uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (in_array($fileType, $allowedTypes)) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $target_dir = "images/";
            $uniqueName = uniqid('pet_', true) . '.' . $extension;
            $target_file = $target_dir . $uniqueName;

            // Move the file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Store the unique file name in the database
                $image = $uniqueName;
            } else {
                echo "Error uploading image.";
                exit();
            }
        } else {
            echo "Invalid image format. Please upload a JPEG or PNG image.";
            exit();
        }
    } else {
        echo "Please select an image.";
        exit();
    }

    // Insert the pet record into the database
    $stmt = $pdo->prepare("INSERT INTO pets (petname, type, description, image, caption, age, location, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$petname, $type, $description, $image, $caption, $age, $location, $username])) {
        header("Location: add.php?add=success");
        exit();
    } else {
        echo "Failed to add the pet. Please try again.";
    }
}
?>
