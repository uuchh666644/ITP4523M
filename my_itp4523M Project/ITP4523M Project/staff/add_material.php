<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../login.php");
    exit();
}
include("../conn.php");

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mname = $_POST['mname'];
    $mqty = $_POST['mqty'];
    $mrqty = $_POST['mrqty'];
    $munit = $_POST['munit'];
    $mreorderqty = $_POST['mreorderqty'];
    $stmt = $conn->prepare("INSERT INTO material (mname, mqty, mrqty, munit, mreorderqty) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siisi", $mname, $mqty, $mrqty, $munit, $mreorderqty);
    if ($stmt->execute()) $msg = "Material added!";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Material</title></head>
<body>
<h2>Add Material</h2>
<?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="post">
    <label>Name:</label><input type="text" name="mname" required><br><br>
    <label>Quantity:</label><input type="number" name="mqty" required><br><br>
    <label>Reserved Qty:</label><input type="number" name="mrqty" required><br><br>
    <label>Unit:</label><input type="text" name="munit" required><br><br>
    <label>Reorder Qty:</label><input type="number" name="mreorderqty" required><br><br>
    <button type="submit">Add</button>
</form>
<br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>