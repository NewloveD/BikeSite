<?php
session_start();
require 'includes/db.php';
require 'header.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch rental information for the logged-in user
try {
    $rental_info = $pdo->prepare("SELECT * FROM rentals WHERE user_id = ? AND is_returned = 0");
    $rental_info->execute([$_SESSION['user_id']]);
    $rental_details = $rental_info->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching rental information: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Payment</title>
</head>
<body>
    <div class="content">
        <?php if (isset($_SESSION['return_message'])): ?>
            <div id="session-message" style="color: green; text-align: center;">
                <?php echo htmlspecialchars($_SESSION['return_message']); ?>
            </div>
            <?php unset($_SESSION['return_message']); // Clear the message after displaying ?>
        <?php endif; ?>

        <?php if (empty($rental_details)): ?>
            <h2 style="color: red;">No active rentals found!</h2>
            <p>Please rent a bike first.</p>
        <?php else: ?>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h2>
            <h3>Your Current Rentals:</h3>
            <ul>
                <?php foreach ($rental_details as $rental): ?>
                    <li>
                        <p><strong>Bike ID:</strong> <?php echo htmlspecialchars($rental['bike_id']); ?></p>
                        <p><strong>Time Rented:</strong> <?php echo htmlspecialchars($rental['rental_time']); ?></p>
                        <p><strong>Duration:</strong> 
                            <?php 
                                $rental_time = new DateTime($rental['rental_time']);
                                $now = new DateTime();
                                $interval = $rental_time->diff($now);
                                echo $interval->format('%h hours %i minutes');
                            ?>
                        </p>
                        <form method="POST" action="process_payment.php">
                            <input type="hidden" name="rental_id" value="<?php echo htmlspecialchars($rental['id']); ?>">
                            <label for="return_station_<?php echo $rental['id']; ?>">Return Bike:</label>
                            <select name="return_station" id="return_station_<?php echo $rental['id']; ?>" required>
                                <option value="">Select Return Station</option>
                                <option value="Green Lane">Green Lane</option>
                                <option value="Harwood Arena">Harwood Arena</option>
                                <option value="CAS Building">CAS Building</option>
                                <option value="North Ave Parking Lot">North Ave Parking Lot</option>
                                <option value="Enlow Recital Hall">Enlow Recital Hall</option>
                                <option value="STEM Parking Lot">STEM Parking Lot</option>
                                <option value="Hutchinson Hall">Hutchinson Hall</option>
                            </select>
                            <input type="submit" value="Return Bike">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <script>
        // Function to clear the session message after 5 seconds
        setTimeout(function() {
            const sessionMessage = document.getElementById('session-message');
            if (sessionMessage) {
                sessionMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>
