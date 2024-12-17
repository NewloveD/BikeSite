<?php
require 'includes/db.php';
session_start(); // Start the session before accessing any session variables


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bike_id = $_POST['bike_id'];
    $stmt = $pdo->prepare("UPDATE bikes SET is_rented = 1 WHERE id = ? AND is_rented = 0");
    if ($stmt->execute([$bike_id])) {
        echo "Bike rented successfully!";
    } else {
        echo "Bike is already rented or does not exist.";
    }
}

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