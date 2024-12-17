<?php 
?>

<header>
    <img src="Pictures/KLogo.jpg" alt="Kean University Logo" class="logo"> 

    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="rent_bike.php">Rent a Bike</a></li>
            <li><a href="payment.php">Account</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>