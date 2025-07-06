<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

// 訂單匯總
$sql = "SELECT p.pname, SUM(o.oqty) as total_qty, SUM(o.ocost) as total_sales 
        FROM orders o JOIN product p ON o.pid=p.pid 
        GROUP BY o.pid";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>Generate Report</title></head>
<body>
<h2>Sales Report</h2>
<table border="1">
    <tr>
        <th>Product</th>
        <th>Total Quantity</th>
        <th>Total Sales</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['pname']) ?></td>
            <td><?= $row['total_qty'] ?></td>
            <td>$<?= $row['total_sales'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>