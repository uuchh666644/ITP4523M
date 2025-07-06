<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

$cid = $_SESSION['user_id'];
$msg = "";

// 刪除訂單
if (isset($_GET['oid'])) {
    $oid = intval($_GET['oid']);
    // 只允許刪除ostatus=1
    $stmt = $conn->prepare("DELETE FROM orders WHERE oid=? AND cid=? AND ostatus=1");
    $stmt->bind_param("ii", $oid, $cid);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $msg = "Order deleted!";
    } else {
        $msg = "Delete failed!";
    }
    $stmt->close();
}

// 查詢可刪訂單
$sql = "SELECT o.oid, p.pname, o.oqty, o.ocost, o.odate FROM orders o JOIN product p ON o.pid=p.pid WHERE o.cid=? AND o.ostatus=1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cid);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Order</title>
</head>
<body>
<h2>Delete Order</h2>
<?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Cost</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['oid'] ?></td>
            <td><?= htmlspecialchars($row['pname']) ?></td>
            <td><?= $row['oqty'] ?></td>
            <td>$<?= $row['ocost'] ?></td>
            <td><?= $row['odate'] ?></td>
            <td>
                <a href="?oid=<?= $row['oid'] ?>" onclick="return confirm('Delete this order?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>