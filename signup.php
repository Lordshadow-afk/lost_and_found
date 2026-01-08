<?php
session_start();
// Use the central connection file
include 'db_connect.php';

if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php?msg=registered");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $error = "Username already exists!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doodle Signup</title>
    <style>
        /* IMPORT HANDWRITTEN FONT */
        @import url('https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap');

        body {
            font-family: 'Patrick Hand', sans-serif;
            background-color: #fcfcfc;
            
            /* CHANGE 1: Graph Paper Background (instead of dots) */
            background-image: 
                linear-gradient(#e6e6e6 1px, transparent 1px),
                linear-gradient(90deg, #e6e6e6 1px, transparent 1px);
            background-size: 20px 20px;
            
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        /* THE DOODLE CARD */
        .doodle-card {
            background: #fff;
            padding: 40px;
            /* Hand-drawn feel with straight lines */
            border: 3px solid #333;
            /* CHANGE 2: Different Border Radius (Rounder top-left/bottom-right) */
            border-radius: 25px 5px 25px 5px; 
            box-shadow: -8px 8px 0px rgba(0,0,0,0.1); /* Shadow on left */
            position: relative;
        }

        .doodle-card h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-top: 0;
            margin-bottom: 30px;
            /* CHANGE 3: Blue Underline */
            border-bottom: 3px solid #87cefa;
            display: inline-block;
            width: 100%;
            padding-bottom: 10px;
        }

        /* INPUT FIELDS */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-size: 1.2rem;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .doodle-input {
            width: 100%;
            padding: 10px;
            font-family: 'Patrick Hand', sans-serif;
            font-size: 1.2rem;
            border: 2px solid #333;
            border-radius: 4px;
            background: #fff;
            outline: none;
            box-sizing: border-box;
        }

        .doodle-input:focus {
            /* CHANGE 4: Blue Focus Tint */
            background-color: #e6f7ff; 
            border-color: #000;
        }

        /* BUTTON */
        .doodle-btn {
            width: 100%;
            padding: 15px;
            font-family: 'Patrick Hand', sans-serif;
            font-size: 1.5rem;
            /* CHANGE 5: Sky Blue Button Color */
            background: #87cefa;
            border: 3px solid #333;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: bold;
            box-shadow: 2px 2px 0 #333;
            transition: all 0.1s;
        }

        .doodle-btn:active {
            box-shadow: none;
            transform: translate(2px, 2px);
        }
        
        .doodle-btn:hover {
            /* Darker Blue on Hover */
            background: #5cb8e6;
        }

        /* LINKS */
        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 1.1rem;
        }

        .links a {
            color: #333;
            text-decoration: none;
            border-bottom: 2px solid #333;
        }
        
        .alert-error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="doodle-card">
        <h2>Join the Sketch</h2>
        
        <?php if(isset($error)): ?>
            <div class="alert-error">⚠ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Choose a Username</label>
                <input type="text" name="username" class="doodle-input" placeholder="Pick a name..." required>
            </div>
            
            <div class="form-group">
                <label>Create Password</label>
                <input type="password" name="password" class="doodle-input" placeholder="Make it secret..." required>
            </div>
            
            <button type="submit" name="signup" class="doodle-btn">Sign Me Up!</button>
        </form>
        
        <div class="links">
            <p>Already have an ID? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>

</body>
</html>