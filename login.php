<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'root', 'lost_found_db');

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify Password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Wrong password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="nav-bar">
        <div class="nav-title">MEMBER_LOGIN</div>
        <div class="nav-links"><a href="index.php">HOME</a></div>
    </div>

    <div class="form-wrapper">
        <h2>IDENTIFY YOURSELF</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <?php if(isset($_GET['msg'])) echo "<p style='color:green'>Registration successful! Please login.</p>"; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="submit-btn">ENTER PORTAL</button>
        </form>
        <p>New here? <a href="signup.php">Register now</a></p>
    </div>
</div>
</body>
</html>