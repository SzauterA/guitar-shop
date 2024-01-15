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
    <title>Products</title>
</head>
<body>
    <h1>Electric guitars:</h1>
    <?php
    require_once './db_config.php';
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT  guitars_id, 
                    brand,
                    model, 
                    price
            FROM products";
    $result = mysqli_query($conn, $sql);
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            print("<form method='post'>");
            print($row["brand"]." ".$row["model"]."<br>");
            print("Price: ".$row["price"]."€"."<br>");
            print("<input type='submit' name='addToCart' value='Add to Cart'>");

            print("<input type='hidden' name='productId' value='".$row["guitars_id"]."'>");
            print("<input type='hidden' name='productBrand' value='".$row["brand"]."'>");
            print("<input type='hidden' name='productModel' value='".$row["model"]."'>");
            print("<input type='hidden' name='productPrice' value='".$row["price"]."'>");
            print("</form><br>"); 
        }
    }else {
        print(mysqli_errno($conn));
        print('<br>');
        print(mysqli_error($conn));
    }        
    mysqli_close($conn);

    $productId = $_POST['productId'] ?? '';
    $productBrand = $_POST['productBrand'] ?? '';
    $productModel = $_POST['productModel'] ?? '';
    $productPrice = $_POST['productPrice'] ?? ''; 

    addToCart($productId, $productBrand, $productModel, $productPrice);
    ?> 
</body>
<footer>
    <br>
    <a href="index.php">Back to main page</a>
    <br>
    <a href="shoppingcart.php">Go to shopping cart</a>
</footer>
</html>
