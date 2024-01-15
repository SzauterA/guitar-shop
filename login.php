<?php
session_start(); 
require_once './functions.php';
showStatus();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>
    <h1>Log in</h1>
    <h2>Please fill in the fields below to enter your account.</h2> 
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email">
        <br>
        <label>Password:</label>
        <input type='password' name='password'>
        <br>
        <button type="submit" name="submit">Log in</button>
    </form>
    <?php
    if (isset($_POST["submit"])) {
        $email = $_POST["email"];
        $userPassword = $_POST["password"];
        
        require_once './db_config.php';
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $stmt = mysqli_prepare($conn, "SELECT * FROM customers WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];
            if (password_verify($userPassword, $hashedPassword)) {
                $_SESSION['user_id'] = $row['customer_id'];
                $_SESSION['user_email'] = $row['email'];
                header("Location: index.php");
                exit;
            } else {
                print('Wrong password: ' . $row['email']);
            }
        } else {
            print('Wrong email: ' . $email);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }   
    ?>
</body>
<footer>
    <br>
    <a href="index.php">Back to main page</a>
    <br>
    <a href="shoppingcart.php">Go to shopping cart</a>
</footer>
</html>