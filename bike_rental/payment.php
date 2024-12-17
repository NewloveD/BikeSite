<?php
session_start();
require 'includes/db.php';
require 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch bike rental details for the user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM rentals WHERE user_id = ? AND is_returned = 0");
$stmt->execute([$user_id]);
$rental_info = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rental_info) {
    echo "No current rentals found.";
    exit;
}

// Calculate rental duration
$current_time = new DateTime();
$rented_time = new DateTime($rental_info['rental_time']);
$interval = $current_time->diff($rented_time);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Payment</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <h3>Bike currently renting: <?php echo htmlspecialchars($rental_info['bike_id']); ?></h3>
    <h3>Time of Bike Rented: <?php echo htmlspecialchars($rental_info['rental_time']); ?></h3>
    <h3>Duration of Rental: <?php echo $interval->format('%h hours %i minutes'); ?></h3>
    
    <form method="POST" action="process_payment.php"> <!-- Assuming you have a return_bike.php -->
        <label for="return_station">Return Bike:</label>
        <select name="return_station" required>
            <option value="Green Lane">Green Lane</option>
            <option value="Harwood Arena">Harwood Arena</option>
            <option value="CAS Building">CAS Building</option>
            <option value="North Ave Parking Lot">North Ave Parking Lot</option>
            <option value="Enlow Recital Hall">Enlow Recital Hall</option>
            <option value="STEM Parking Lot">STEM Parking Lot</option>
            <option value="Hutchinson Hall">Hutchinson Hall</option>
            <!-- Add other stations as needed -->
        </select>
        <input type="submit" value="Submit">
    </form>
</body>
</html>