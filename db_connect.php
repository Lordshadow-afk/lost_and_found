<?php
// XAMPP Default Configuration for your setup
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Default XAMPP password is empty
$db_name = 'lost_found_db';
$db_port = 3307; // This is crucial based on your screenshot

try {
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
} catch (mysqli_sql_exception $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>