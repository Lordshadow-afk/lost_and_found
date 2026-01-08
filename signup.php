<?php
session_start();
include 'db_connect.php';

if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?msg=registered");
    } else {
        $error = "Username already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="nav-bar">
        <div class="nav-title">JOIN_THE_PORTAL</div>
        <div class="nav-links"><a href="index.php">HOME</a></div>
    </div>

    <div class="form-wrapper">
        <h2>CREATE ACCOUNT</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="signup" class="submit-btn">REGISTER</button>
        </form>
        <p>Already have an ID? <a href="login.php">Login here</a></p>
    </div>
</div>
</body>
</html>