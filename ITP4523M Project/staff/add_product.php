<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pname = $_POST['pname'];
    $pdesc = $_POST['pdesc'];
    $pcost = $_POST['pcost'];
    $stmt = $conn->prepare("INSERT INTO product (pname, pdesc, pcost) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $pname, $pdesc, $pcost);
    if ($stmt->execute()) $msg = "Product added!";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Product</title></head>
<body>
<h2>Add Product</h2>
<?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="post">
    <label>Name:</label><input type="text" name="pname" required><br><br>
    <label>Description:</label><input type="text" name="pdesc"><br><br>
    <label>Cost:</label><input type="number" step="0.01" name="pcost" required><br><br>
    <button type="submit">Add</button>
</form>
<br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>