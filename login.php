<?php
session_start();
// Use the central connection file we fixed earlier
include 'db_connect.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doodle Login</title>
    <style>
        /* IMPORT HANDWRITTEN FONT */
        @import url('https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap');

        body {
            font-family: 'Patrick Hand', sans-serif;
            background-color: #fcfcfc;
            /* Dot grid background pattern */
            background-image: radial-gradient(#d1d1d1 1px, transparent 1px);
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
            border-radius: 5px 25px 5px 25px; 
            box-shadow: 8px 8px 0px rgba(0,0,0,0.1); 
            position: relative;
        }

        .doodle-card h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-top: 0;
            margin-bottom: 30px;
            border-bottom: 3px solid #ffcc00;
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
            background-color: #fffde7; /* Light yellow focus */
            border-color: #000;
        }

        /* BUTTON */
        .doodle-btn {
            width: 100%;
            padding: 15px;
            font-family: 'Patrick Hand', sans-serif;
            font-size: 1.5rem;
            background: #ffcc00;
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
        
        .alert-success {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="doodle-card">
        <h2>Member Login</h2>

        <?php if(isset($error)): ?>
            <div class="alert-error">⚠ <?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'registered'): ?>
            <div class="alert-success">✔ Registration successful! Please login.</div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Who are you?</label>
                <input type="text" name="username" class="doodle-input" placeholder="Enter username..." required>
            </div>
            
            <div class="form-group">
                <label>Secret Code</label>
                <input type="password" name="password" class="doodle-input" placeholder="Enter password..." required>
            </div>
            
            <button type="submit" name="login" class="doodle-btn">Let Me In!</button>
        </form>
        
        <div class="links">
            <p>New here? <a href="signup.php">Sketch a new account</a></p>
        </div>
    </div>
</div>

</body>
</html>