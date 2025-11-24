<?php
$conn = mysqli_connect('localhost', 'root', '', 'lost_found_db');

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Image Upload Logic
    $target_dir = "uploads/";
    // Ensure unique filename to prevent overwriting
    $filename = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $filename;
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    
    if($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO lost_items (name, category, location, description, image) 
                    VALUES ('$name', '$category', '$location', '$desc', '$target_file')";
            
            if(mysqli_query($conn, $sql)){
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Oddity</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="nav-bar">
        <div class="nav-title">ADD_NEW_ODDITY</div>
        <div class="nav-links">
            <a href="index.php">BACK TO LIST</a>
        </div>
    </div>

    <div class="form-wrapper">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="name" placeholder="What did you find?" required>
            </div>

            <div class="form-group">
                <label>Category (Product Type)</label>
                <select name="category" required>
                    <option value="Electronics">Electronics</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Pets">Pets</option>
                    <option value="Documents">Documents</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Location Found (Specific)</label>
                <input type="text" name="location" placeholder="e.g. Under the rusty bench" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5" placeholder="Describe the item..." required></textarea>
            </div>

            <div class="form-group">
                <label>Image Evidence (Required)</label>
                <input type="file" name="image" required accept="image/*">
            </div>

            <button type="submit" name="submit" class="submit-btn">PUBLISH ODDITY</button>
        </form>
    </div>
</div>

</body>
</html>