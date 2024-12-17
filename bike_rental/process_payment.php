<?php
session_start();
require 'includes/db.php';


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize variables to store bike details
$bike_id = null;
$rented_time = null;

// Check if we have a rental record for the user
$stmt = $pdo->prepare("SELECT bike_id, rental_time FROM rentals WHERE user_id = ? AND is_returned = 0");
$stmt->execute([$_SESSION['user_id']]);
$rental = $stmt->fetch(PDO::FETCH_ASSOC);

if ($rental) {
    $bike_id = $rental['bike_id'];
    $rented_time = $rental['rental_time'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $return_station = $_POST['return_station'];

    // Start a transaction
    $pdo->beginTransaction();
    
    try {
        // Update the rental record to mark the bike as returned
        $stmt = $pdo->prepare("UPDATE rentals SET is_returned = 1, return_station = ? WHERE user_id = ? AND bike_id = ?");
        $stmt->execute([$return_station, $user_id, $bike_id]);

        // Update the bikes table to set is_rented to 0
        $stmt = $pdo->prepare("UPDATE bikes SET is_rented = 0 WHERE id = ?");
        $stmt->execute([$bike_id]);

        // Commit the transaction
        $pdo->commit();

        echo "Bike returned successfully!";
        header("Location: index.php");
        exit;

    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $pdo->rollBack();
        echo "Error returning the bike. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Return Bike</title>
</head>
<body>
    <h2>Return Bike</h2>

    <?php if ($bike_id): ?>
        <form method="POST">
            <label for="return_station">Select Return Station:</label>
            <select name="return_station" required>
                <option value="Green Lane">Green Lane</option>
                <option value="Harwood Arena">Harwood Arena</option>
                <option value="CAS Building">CAS Building</option>
                <option value="North Ave Parking Lot">North Ave Parking Lot</option>
                <option value="Enlow Recital Hall">Enlow Recital Hall</option>
                <option value="STEM Parking Lot">STEM Parking Lot</option>
                <option value="Hutchinson Hall">Hutchinson Hall</option>
            </select>
            <input type="submit" value="Submit">
        </form>
    <?php else: ?>
        <p>No bike currently rented. Please rent a bike first.</p>
    <?php endif; ?>

</body>
</html>