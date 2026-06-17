<?php
// db_connect.inc

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $servername = "localhost";
    $username = "root"; // Local MySQL username
    $password = ""; // Local MySQL password
    $dbname = "petsvictoria"; // Local database name
} else {
    $servername = "talsprddb02.int.its.rmit.edu.au"; // RMIT server address
    $username = "s4090915"; // RMIT MySQL username
    $password = "P@@rth12e"; // RMIT MySQL password
    $dbname = "s4090915"; // RMIT database name
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
