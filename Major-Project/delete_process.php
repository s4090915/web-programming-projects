<?php
session_start();
include('includes/db_connect.inc');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petid = $_POST['petid'];
    $old_pet = $db->query("SELECT image FROM pets WHERE petid = $petid")->fetch_assoc();
    $old_image = $old_pet['image'];
    unlink("images/$old_image"); // Delete the old image

    $stmt = $db->prepare("DELETE FROM pets WHERE petid = ?");
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    header("Location: pets.php");
}
?>
