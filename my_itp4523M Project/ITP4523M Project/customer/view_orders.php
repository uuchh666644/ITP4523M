<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

$cid = $_SESSION['user_id'];
$sql = "SELECT o.*, p.pname FROM orders o JOIN product p ON o.pid=p.pid WHERE o.cid=? ORDER BY o.odate DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cid);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
</head>
<body>
<h2>Your Orders</h2>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Cost</th>
        <th>Date</th>
        <th>Status</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['oid'] ?></td>
            <td><?= htmlspecialchars($row['pname']) ?></td>
            <td><?= $row['oqty'] ?></td>
            <td>$<?= $row['ocost'] ?></td>
            <td><?= $row['odate'] ?></td>
            <td>
                <?php
                switch ($row['ostatus']) {
                    case 1: echo "Pending"; break;
                    case 2: echo "Processing"; break;
                    case 3: echo "Delivered"; break;
                    default: echo "Unknown";
                }
                ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>