<?php
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $conn = new mysqli('localhost', 'root', '', 'library_management');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

   
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = $conn->query($checkEmailQuery);

    if ($checkResult->num_rows > 0) {
        $message = "Email is already registered!";
    } else {
    
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $insertQuery = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
        if ($conn->query($insertQuery) === TRUE) {
            $message = "Registration successful! Please log in.";
            header('Location: login.php');
            exit();
        } else {
            $message = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style5.css">
    <title>Register - Online Library Management</title>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Nexus Library</h1>
        </div>
    </header>

    <section class="form-section">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Register</button>
        </form>
        <?php if (!empty($message)): ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </section>

    <footer>
        <p>&copy; 2024 Online Library Management. All rights reserved.</p>
    </footer>
</body>
</html>

