<?php
session_start(); // Start the session before accessing any session variables

require 'includes/db.php';
require 'header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Dummy data for demonstration purposes
$bike_rent_number = 1; // Replace with actual bike rent number
$rented_time = '2 hours'; // Replace with actual rented time
?>
<link rel="stylesheet" href="css/styles.css">
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2> <!-- Fix: Use $_SESSION['username'] -->
<p>Bike currently renting: <?php echo $bike_rent_number; ?></p>
<p>Time of Bike Rented: <?php echo $rented_time; ?></p>

<form method="POST" action="process_payment.php">
    <label for="return_station">Return Bike:</label>
    <select name="return_station" id="return_station">
        <option value="Green Lane">Green Lane</option>
        <option value="Harwood Arena">Harwood Arena</option>
        <option value="CAS Building">CAS Building</option>
        <option value="North Ave Parking Lot">North Ave Parking Lot</option>
        <option value="Enlow Recital Hall">Enlow Recital Hall</option>
        <option value="STEM Parking Lot">STEM Parking Lot</option>
        <option value="Hutchinson Hall">Hutchinson Hall</option>
    </select>
    
    <h3>Enter your payment method:</h3>
    <input type="text" name="card_number" placeholder="Credit Card Number" required>
    <input type="text" name="expiry_date" placeholder="MM/YY" required>
    <input type="text" name="cvv" placeholder="CVV" required>
    <input type="submit" value="Submit">
</form>

<a href="logout.php">Log Out</a>
