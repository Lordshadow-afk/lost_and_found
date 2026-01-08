<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'lost_found_db');

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check Ownership
$check_sql = "SELECT * FROM lost_items WHERE id='$id' AND user_id='$user_id'";
$result = mysqli_query($conn, $check_sql);
if (mysqli_num_rows($result) == 0) { die("ACCESS DENIED: You do not own this item."); }

$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Only update text fields for simplicity (Image update omitted for "hurried" feel)
    $sql = "UPDATE lost_items SET name='$name', location='$location', description='$desc' WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="nav-bar">
        <div class="nav-title">EDIT_ITEM</div>
        <div class="nav-links"><a href="index.php">CANCEL</a></div>
    </div>
    <div class="form-wrapper">
        <form method="POST">
            <div class="form-group"><label>Item Name</label><input type="text" name="name" value="<?php echo $row['name']; ?>" required></div>
            <div class="form-group"><label>Location</label><input type="text" name="location" value="<?php echo $row['location']; ?>" required></div>
            <div class="form-group"><label>Description</label><textarea name="description" rows="5" required><?php echo $row['description']; ?></textarea></div>
            <button type="submit" name="update" class="submit-btn">SAVE CHANGES</button>
        </form>
    </div>
</div>
</body>
</html>