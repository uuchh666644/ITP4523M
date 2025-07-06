<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

// 下單處理
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = intval($_POST['pid']);
    $qty = intval($_POST['qty']);
    $cid = $_SESSION['user_id'];
    // 查詢單價
    $stmt = $conn->prepare("SELECT pcost FROM product WHERE pid=?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->bind_result($pcost);
    $stmt->fetch();
    $stmt->close();
    $ocost = $qty * $pcost;

    // 新增訂單
    $stmt = $conn->prepare("INSERT INTO orders (odate, pid, oqty, ocost, cid, ostatus) VALUES (NOW(), ?, ?, ?, ?, 1)");
    $stmt->bind_param("iidi", $pid, $qty, $ocost, $cid);
    if ($stmt->execute()) {
        $msg = "Order placed successfully!";
    } else {
        $msg = "Order failed!";
    }
    $stmt->close();
}

// 產品清單
$products = $conn->query("SELECT * FROM product");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Make Order</title>
</head>
<body>
<h2>Make Order</h2>
<?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="post">
    <label>Product:</label>
    <select name="pid" required>
        <?php while($row = $products->fetch_assoc()): ?>
            <option value="<?= $row['pid'] ?>">
                <?= htmlspecialchars($row['pname']) . " ($" . $row['pcost'] . ")" ?>
            </option>
        <?php endwhile; ?>
    </select>
    <br><br>
    <label>Quantity:</label>
    <input type="number" name="qty" value="1" min="1" required>
    <br><br>
    <button type="submit">Order</button>
</form>
<br>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>