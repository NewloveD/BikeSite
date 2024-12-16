<?php
session_start();
?>

<header>
    <h1>Welcome to Bike Rental</h1>
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                <li><a href="rent_bike.php">Rent a Bike</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>