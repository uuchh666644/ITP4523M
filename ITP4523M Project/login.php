<?php
session_start();
include("conn.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($role == "customer") {
        $sql = "SELECT * FROM customer WHERE cname=? AND cpassword=?";
    } else if ($role == "staff") {
        $sql = "SELECT * FROM staff WHERE sname=? AND spassword=?";
    } else {
        $error = "Please select a role.";
    }

    if (empty($error)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $_SESSION['login_user'] = $username;
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = ($role=='customer') ? $row['cid'] : $row['sid'];
            // 跳轉
            header("Location: " . ($role == 'customer' ? "customer/dashboard.php" : "staff/dashboard.php"));
            exit();
        } else {
            $error = "Username or password incorrect.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="post">
    <label>Role:</label>
    <select name="role" required>
        <option value="">--Select--</option>
        <option value="customer">Customer</option>
        <option value="staff">Staff</option>
    </select><br><br>
    <label>Username:</label>
    <input type="text" name="username" required><br><br>
    <label>Password:</label>
    <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>
<p style="color:red;"><?php echo $error; ?></p>
</body>
</html>