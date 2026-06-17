<?php
session_start();
require('includes/db_connect.inc'); // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = sha1($_POST['password']); // Hash the entered password

    // Check if the user exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        // User found, start session and redirect with success flag
        $_SESSION['user_id'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php?login=success"); // Redirect to home with success flag
        exit();
    } else {
        // Redirect back to login page with an error message
        header("Location: login.php?error=incorrect");
        exit();
    }
}
?>
