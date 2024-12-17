<?php
require 'includes/db.php'; // This file contains the PDO connection: $pdo
require 'header.php'; // Include the header file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare the SQL query to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        
        // Bind the parameters to the SQL query
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Registration failed!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the database connection (optional with PDO, as it will close when the script ends)
$pdo = null;
?>

<!-- HTML Form -->
<link rel="stylesheet" href="css/styles.css"> 
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Register">
</form>