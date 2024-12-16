<?php
$host = 'localhost';
$port = '3309'; // or '3306' if that's the port you are using
$db = 'bike_rental';
$user = 'root';
$pass = ''; // Set this to your root password if you have one

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>