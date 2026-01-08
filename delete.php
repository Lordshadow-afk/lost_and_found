<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'lost_found_db');

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // SECURITY CHECK: Does this item belong to this user?
    $check = "SELECT * FROM lost_items WHERE id='$id' AND user_id='$user_id'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Delete image file (Optional cleanup)
        // unlink($row['image']); 
        
        // Delete record
        $sql = "DELETE FROM lost_items WHERE id='$id'";
        mysqli_query($conn, $sql);
    } else {
        die("ACCESS DENIED: You cannot delete items you didn't post.");
    }
}
header("Location: index.php");
?>