<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oid = $_POST['oid'];
    $ostatus = $_POST['ostatus'];
    $odeliverdate = ($_POST['ostatus'] == 3) ? date("Y-m-d H:i:s") : NULL;
    $stmt = $conn->prepare("UPDATE orders SET ostatus=?, odeliverdate=? WHERE oid=?");
    $stmt->bind_param("isi", $ostatus, $odeliverdate, $oid);
    if ($stmt->execute()) $msg = "Order updated!";
    $stmt->close();
}

// 查詢所有訂單
$sql = "SELECT o.*, c.cname, p.pname FROM orders o JOIN customer c ON o.cid=c.cid JOIN product p ON o.pid=p.pid ORDER BY o.odate DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>Update Order</title></head>
<body>
<h2>Update Order</h2>
<?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
<table border="1">
    <tr>
        <th>Order ID</th><th>Customer</th><th>Product</th><th>Qty</th><th>Status</th><th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="post">
                <td><?= $row['oid'] ?></td>
                <td><?= htmlspecialchars($row['cname']) ?></td>
                <td><?= htmlspecialchars($row['pname']) ?></td>
                <td><?= $row['oqty'] ?></td>
                <td>
                    <select name="ostatus">
                        <option value="1" <?= $row['ostatus']==1?'selected':'' ?>>Pending</option>
                        <option value="2" <?= $row['ostatus']==2?'selected':'' ?>>Processing</option>
                        <option value="3" <?= $row['ostatus']==3?'selected':'' ?>>Delivered</option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="oid" value="<?= $row['oid'] ?>">
                    <button type="submit">Update</button>
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
</table>
<br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>