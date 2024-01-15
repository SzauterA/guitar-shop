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
    <title>Main page</title>
</head>
<body>
    <h1>Guitar store</h1>
    <h2>Welcome to our page.</h2>
    <a href="products.php">Products</a>
    <br>
    <a href="shoppingcart.php">Go to shopping cart</a>
</body>
</html>