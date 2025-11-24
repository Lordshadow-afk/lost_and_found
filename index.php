<?php
// Database Connection
$conn = mysqli_connect('localhost', 'root', '', 'lost_found_db',3307);
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

// Filter Logic
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT * FROM lost_items";
if ($category_filter && $category_filter != 'All') {
    $safe_cat = mysqli_real_escape_string($conn, $category_filter);
    $sql .= " WHERE category = '$safe_cat'";
}

// Order by Date (Newest First)
$sql .= " ORDER BY date_added DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lost & Found Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <!-- Nav Bar -->
    <div class="nav-bar">
        <div class="nav-title">LOST_&_FOUND_DB</div>
        <div class="nav-links">
            <a href="add.php">+ NEW ENTRY</a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <span>FILTER_BY_CAT:</span>
        <a href="index.php">ALL</a>
        <a href="index.php?category=Electronics">ELECTRONICS</a>
        <a href="index.php?category=Clothing">CLOTHING</a>
        <a href="index.php?category=Pets">PETS</a>
        <a href="index.php?category=Documents">DOCUMENTS</a>
        <a href="index.php?category=Other">OTHER</a>
    </div>

    <!-- Item Grid -->
    <div class="grid">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Item Image">
                    <div class="card-meta">
                        <span><?php echo htmlspecialchars($row['category']); ?></span>
                        <span><?php echo htmlspecialchars($row['location']); ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    <div class="timestamp">Added: <?php echo $row['date_added']; ?></div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>NO ITEMS FOUND.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>