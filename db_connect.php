<?php
$db_host = 'localhost:8080';
$db_user = 'root';

// --- PASSWORD FIX ---
// You are getting "Access Denied" because your database expects a password.
// 1. Try 'root' inside the quotes: $db_pass = 'root';
// 2. If that fails, try 'admin' or 'password'.
// 3. If you know your specific MySQL password, put it there.
$db_pass = 'root'; // <--- CHANGE THIS (e.g., 'root')

$db_name = 'lost_found_db';

try {
    // We use this single file to connect everywhere
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>