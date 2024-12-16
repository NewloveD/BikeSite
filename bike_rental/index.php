<?php
session_start();
?>

<h1>Welcome to Bike Rental</h1>
<link rel="stylesheet" href="css/styles.css">
<?php if (isset($_SESSION['user_id'])): ?>
    <p>Hello, User!</p>
    <a href="rent_bike.php">Rent a Bike</a>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
<?php endif; ?>