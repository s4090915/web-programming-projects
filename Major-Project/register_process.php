<?php
require('includes/db_connect.inc');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = sha1($password); // Hash the password with SHA-1

    // Insert the user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, password, reg_date) VALUES (?, ?, NOW())");
    if ($stmt->execute([$username, $hashed_password])) {
        header("Location: login.php?register=success"); // Redirect to login page on success
        exit();
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>
