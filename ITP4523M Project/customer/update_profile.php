<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

$cid = $_SESSION['user_id'];
$msg = "";

// 資料修改
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cname = $_POST['cname'];
    $ctel = $_POST['ctel'];
    $caddr = $_POST['caddr'];
    $company = $_POST['company'];
    $stmt = $conn->prepare("UPDATE customer SET cname=?, ctel=?, caddr=?, company=? WHERE cid=?");
    $stmt->bind_param("sissi", $cname, $ctel, $caddr, $company, $cid);
    if ($stmt->execute()) {
        $msg = "Profile updated!";
        $_SESSION['login_user'] = $cname;
    }
    $stmt->close();
}

// 讀取現有資料
$stmt = $conn->prepare("SELECT * FROM customer WHERE cid=?");
$stmt->bind_param("i", $cid);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
</head>
<body>
<h2>Update Profile</h2>
<?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="post">
    <label>Name:</label>
    <input type="text" name="cname" value="<?= htmlspecialchars($row['cname']) ?>" required><br><br>
    <label>Tel:</label>
    <input type="text" name="ctel" value="<?= htmlspecialchars($row['ctel']) ?>"><br><br>
    <label>Address:</label>
    <input type="text" name="caddr" value="<?= htmlspecialchars($row['caddr']) ?>"><br><br>
    <label>Company:</label>
    <input type="text" name="company" value="<?= htmlspecialchars($row['company']) ?>"><br><br>
    <button type="submit">Update</button>
</form>
<br>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>