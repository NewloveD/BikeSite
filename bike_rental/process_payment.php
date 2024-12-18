<?php
session_start();
require 'includes/db.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch rental information for the logged-in user
$bike_id = null;
$rented_time = null;

try {
    $stmt = $pdo->prepare("SELECT bike_id, rental_time FROM rentals WHERE user_id = ? AND is_returned = 0");
    $stmt->execute([$_SESSION['user_id']]);
    $rental = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rental) {
        $bike_id = $rental['bike_id'];
        $rented_time = $rental['rental_time'];
    }
} catch (PDOException $e) {
    die("Error fetching rental details: " . $e->getMessage());
}

// Handle the return bike request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $bike_id) {
    $user_id = $_SESSION['user_id'];
    $return_station = $_POST['return_station'];
    $return_time = date('Y-m-d H:i:s'); // Get the current return time

    // Begin a database transaction
    $pdo->beginTransaction();

    try {
        // Update the `bikes` table to mark the bike as not rented and store the return station
        $stmt = $pdo->prepare(
            "UPDATE bikes 
             SET is_rented = 0, return_station = ? 
             WHERE id = ? 
             AND EXISTS (
                 SELECT 1 
                 FROM rentals 
                 WHERE user_id = ? 
                 AND bike_id = bikes.id 
                 AND is_returned = 0
             )"
        );
        $stmt->execute([$return_station, $bike_id, $user_id]);

        // Update the `rentals` table to mark the bike as returned and record the return time
        $stmt = $pdo->prepare(
            "UPDATE rentals 
             SET is_returned = 1, return_time = ? 
             WHERE user_id = ? 
             AND bike_id = ?"
        );
        $stmt->execute([$return_time, $user_id, $bike_id]);

        // Commit the transaction
        $pdo->commit();

        // Set success message and redirect to payment page
        $_SESSION['return_message'] = "Bike returned successfully!";
        header("Location: payment.php");
        exit;

    } catch (Exception $e) {
        // Rollback the transaction on failure
        $pdo->rollBack();

        // Set error message and redirect to payment page
        $_SESSION['return_message'] = "Error returning the bike. Please try again.";
        header("Location: payment.php");
        exit;
    }
}
?>
