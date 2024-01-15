<?php
session_start(); 
require_once './functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
</head>
<body>
    <h1>Order details</h1>
    <?php
        require_once './db_config.php';
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT  customer_id,
                        first_name, 
                        last_name,
                        email, 
                        phone_number,
                        address
                FROM customers
                WHERE customer_id = '{$_SESSION['user_id']}'";
        $result = mysqli_query($conn, $sql);
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $customerId = $row["customer_id"];
                print("First name: ".$row["first_name"]."<br>");
                print("Last name: ".$row["last_name"]."<br>");
                print("Email address: ".$row["email"]."<br>");
                print("Phone number: ".$row["phone_number"]."<br>");
                print("Address: ".$row["address"]."<br>");
            }
        }else {
            print(mysqli_errno($conn));
            print('<br>');
            print(mysqli_error($conn));
        }        
        print('<br>');

        $totalPrice = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $cartItems) {
                foreach ($cartItems as $key => $value) {
                    print(" $value");
                    if ($key === 'Price') {
                        $totalPrice += (float)$value;
                    }
                }
                print("€ ");
                print('<br>');
            }
        }
        print("<br> Total: ".$totalPrice."€");

        if (isset($_POST['sendOrder'])) {
            $orderDate = date("Y-m-d");
            $sql = "INSERT INTO orders(customer_id, order_date, total_price)
                    VALUES ('$customerId', '$orderDate', '$totalPrice')";
            mysqli_query($conn, $sql);

            $order_id = mysqli_insert_id($conn);

            foreach ($_SESSION['cart'] as $cartItem) {
                $productId = $cartItem['ID'];
                $sql = "INSERT INTO orderproducts(order_id, guitars_id)
                        VALUES ('$order_id', '$productId')";
                mysqli_query($conn, $sql);
            }    

            if(mysqli_errno($conn)) {
                print("Error: " . mysqli_error($conn));
            } else {
                header("Location: index.php");
                $_SESSION['cart'] = array();
            } 
            mysqli_close($conn);
        }
    ?>
    <form method="POST">
    <h2>Order and pay:</h2>
    <input type="submit" name="sendOrder" value="Send order">
    </form>
</body>
<footer>
    <br>
    <a href="shoppingcart.php">Back to the cart</a>
</footer>
</html>