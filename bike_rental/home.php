<?php  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Kean University Bike Rental</title>
</head>
<body>
<?php require 'header.php'; ?>

    <main>
        <section class="welcome-section">
            <h1>Kean University Bike Rental</h1>
            <p>Welcome to the Bike Rental Extravaganza! So, where are we pedaling off to today, and when do you want to hop on that two-wheeled thrill ride?</p>
        </section>

        <section class="image-section">
            <img src="Pictures/citi.jpg" alt="Bike Rental" class="bike-image">
        </section>
    </main>

    <footer>
        <?php
    echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
        <p>@KeanUnivesity</p>
        <div class="social-media">
            <a href="#">Instagram</a>
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">LinkedIn</a>
        </div>
    </footer>
</body>
</html>