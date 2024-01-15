<?php
session_start(); 
require_once './functions.php';
statusCheck();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout page</title>
</head>
<body>
    <h1>Log out</h1>
    <h2>Please click on the button to log out from your account.</h2>
    <form method="POST">
        <button type="submit" name="submit">Log out</button>
    </form>  
    <?php
    if (isset($_POST["submit"])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
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