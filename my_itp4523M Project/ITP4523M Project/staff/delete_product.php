<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

$msg = "";
if (isset($_GET['pid'])) {
    $pid = intval($_GET['pid']);
    $stmt = $conn->prepare("DELETE FROM product WHERE pid=?");
    $stmt->bind_param("i", $pid);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $msg = "Product deleted!";
    } else {
        $msg = "Delete failed! Product may be used in orders.";
    }
    $stmt->close();
}

// 產品清單
$result = $conn->query("SELECT * FROM product");
?>
<!DOCTYPE html>
<html>
<head><title>Delete Product</title></head>
<body>
<h2>Delete Product</h2>
<?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
<table border="1">
    <tr>
        <th>Product ID</th><th>Name</th><th>Description</th><th>Cost</th><th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['pid'] ?></td>
            <td><?= htmlspecialchars($row['pname']) ?></td>
            <td><?= htmlspecialchars($row['pdesc']) ?></td>
            <td>$<?= $row['pcost'] ?></td>
            <td>
                <a href="?pid=<?= $row['pid'] ?>" onclick="return confirm('Delete this product?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>