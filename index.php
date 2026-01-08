<?php
session_start();
include 'db_connect.php';

// --- SECURITY GATE ---
// If the user is NOT logged in, kick them to login.php immediately.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// ---------------------

$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$sql = "SELECT * FROM lost_items";
if ($category_filter && $category_filter != 'All') {
    $safe_cat = mysqli_real_escape_string($conn, $category_filter);
    $sql .= " WHERE category = '$safe_cat'";
}
$sql .= " ORDER BY date_added DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head><title>Lost & Found</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <div class="nav-bar">
        <div class="nav-title">LOST_&_FOUND_DB</div>
        <div class="nav-links">
            <!-- We removed the Login/Signup buttons because you MUST be logged in to be here -->
            <span class="user-badge">USER: <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="add.php">+ NEW ENTRY</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </div>
    
    <div class="filter-bar">
        <span>FILTER:</span>
        <a href="index.php">ALL</a>
        <a href="index.php?category=Electronics">ELECTRONICS</a>
        <a href="index.php?category=Clothing">CLOTHING</a>
        <a href="index.php?category=Pets">PETS</a>
        <a href="index.php?category=Other">OTHER</a>
    </div>

    <div class="grid">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Item">
                    <div class="card-meta">
                        <span><?php echo htmlspecialchars($row['category']); ?></span>
                        <span><?php echo htmlspecialchars($row['location']); ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    
                    <!-- Only show buttons if the logged-in user owns this item -->
                    <?php if($_SESSION['user_id'] == $row['user_id']): ?>
                        <div class="owner-actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-action">EDIT</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-action btn-delete">DELETE</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>NO ITEMS FOUND.</p>
        <?php endif; ?>
    </div>
    <div class="footer">FOUNDER_CONTACT: +1 (555) 019-9988</div>
</div>
</body>
</html>