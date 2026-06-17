<?php
session_start();
include('includes/db_connect.inc');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petid = $_POST['petid'];
    $petname = $_POST['petname'];
    $description = $_POST['description'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $type = $_POST['type'];

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $old_pet = $db->query("SELECT image FROM pets WHERE petid = $petid")->fetch_assoc();
        $old_image = $old_pet['image'];
        unlink("images/$old_image"); // Delete the old image

        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "images/$image");

        $stmt = $db->prepare("UPDATE pets SET petname = ?, description = ?, age = ?, location = ?, type = ?, image = ? WHERE petid = ?");
        $stmt->bind_param("sssissi", $petname, $description, $age, $location, $type, $image, $petid);
    } else {
        $stmt = $db->prepare("UPDATE pets SET petname = ?, description = ?, age = ?, location = ?, type = ? WHERE petid = ?");
        $stmt->bind_param("ssssi", $petname, $description, $age, $location, $type, $petid);
    }
    $stmt->execute();
    header("Location: pets.php");
}
?>
