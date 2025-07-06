<?php
session_start();
if (!isset($_SESSION['login_user']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
</head>
<body>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['login_user']); ?>!</h2>
<ul>
    <li><a href="make_order.php">Make Order</a></li>
    <li><a href="view_orders.php">View Orders</a></li>
    <li><a href="update_profile.php">Update Profile</a></li>
    <li><a href="delete_order.php">Delete Order</a></li>
    <li><a href="../logout.php">Logout</a></li>
</ul>
</body>
</html>