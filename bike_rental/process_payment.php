<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $return_station = $_POST['return_station'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Here you would process the payment with a payment gateway
    // For now, let's just simulate a success message

    echo "Payment successful! Bike returned at $return_station.";
}
?>
<link rel="stylesheet" href="css/styles.css">
<a href="home.php">Return to Home</a>