<?php
require 'includes/db.php';
require 'header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bike_id = $_POST['bike_id'];
    $current_time = date('Y-m-d H:i:s'); // Get the current time

    // Insert rental with current time
    $stmt = $pdo->prepare("INSERT INTO rentals (user_id, bike_id, rental_time, is_returned) VALUES (?, ?, ?, 0)");
    if ($stmt->execute([$_SESSION['user_id'], $bike_id, $current_time])) {
        // Update the bike's status to rented
        $update_stmt = $pdo->prepare("UPDATE bikes SET is_rented = 1 WHERE id = ?");
        $update_stmt->execute([$bike_id]);
        
        echo "Bike rented successfully!";
    } else {
        echo "Error renting bike.";
    }
}

// Fetch available bikes
$bikes = $pdo->query("SELECT * FROM bikes WHERE is_rented = 0")->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="css/styles.css"> 
<h2>Available Bikes</h2>
<?php if (empty($bikes)): ?>
    <p>No bikes available for rent at the moment.</p>
<?php else: ?>
    <ul>
        <?php foreach ($bikes as $bike): ?>
            <li>
                <?php echo htmlspecialchars($bike['bike_name']); ?>
                <form method="POST">
                    <input type="hidden" name="bike_id" value="<?php echo $bike['id']; ?>">
                    <input type="submit" value="Rent">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>