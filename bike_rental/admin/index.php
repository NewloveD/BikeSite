<?php
session_start();
require '/includes/db.php';
require 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$bikes = $pdo->query("SELECT * FROM bikes")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Bike Inventory</h2>
<table>
    <tr>
        <th>Bike Name</th>
        <th>Status</th>
    </tr>
    <?php foreach ($bikes as $bike): ?>
        <tr>
            <td><?php echo htmlspecialchars($bike['bike_name']); ?></td>
            <td><?php echo $bike['is_rented'] ? 'Rented' : 'Available'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>