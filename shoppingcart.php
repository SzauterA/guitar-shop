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
    <title>Cart</title>
</head>
<body>
    <h1>Your shopping cart</h1>
    <h2>You have a great taste! Check your items!</h2>
    <form method="POST">
    <?php
        $totalPrice = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $cartItems) {
                foreach ($cartItems as $key => $value) {
                    print("$key: $value ");
                    if ($key === 'Price') {
                        $totalPrice += (float)$value;
                    }
                }
                print("€ ");
                print('<button type="submit" name="remove" value="' . $index . '">Remove product from cart</button>');
                print('<br>');
            }
        } else {
            print("Your cart is empty.");
        }
        print("<br> Total: ".$totalPrice."€");

        removeFromCart();
        clearCart();
    ?> 
    <br>
    <br> 
    <h3>Delete all items from your cart:</h3>
    <input type="submit" name="clear" value="Clear">
    <h2>Order item('s):</h2>
    <input type="submit" name="createOrder" value="Create order">
    <?php
        statusCheck(); 
        cartCheck();
    ?>
    </form>
</body>
<footer>
    <br>
    <a href="index.php">Back to main page</a>
    <br>
    <a href="products.php">Go back to shopping</a>
</footer>
</html>