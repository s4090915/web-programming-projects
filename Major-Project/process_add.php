<?php
include('includes/db_connect.inc');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $petname = $_POST['petname'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $caption = $_POST['caption'];
    $age = $_POST['age'];
    $location = $_POST['location'];

    
    $target_dir = "images/";
    $image = $_FILES['image']['name'];
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;

    
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        if ($_FILES['image']['size'] <= 500000) {  
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO pets (petname, type, description, image, caption, age, location)
                                           VALUES (:petname, :type, :description, :image, :caption, :age, :location)");
                    $stmt->execute([
                        ':petname' => $petname,
                        ':type' => $type,
                        ':description' => $description,
                        ':image' => $image,
                        ':caption' => $caption,
                        ':age' => $age,
                        ':location' => $location
                    ]);
                    echo "New pet added successfully!";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, your file is too large.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>
