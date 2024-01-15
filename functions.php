<?php
function showStatus() {
    if(isset($_SESSION['user_id'])) {
        print("You are logged in. ".'<a href="logout.php">Log out</a>');
        print("<br>");
    } else {
        print("You are not logged in currently. ".'<a href="login.php">Log in</a>');
        print("<br>");
    }
    print("You don't have an account? ".'<a href="signin.php">Sign in</a>');
}

function checkNames($firstName, $lastName) {
    $error = [];
    if (strlen($firstName) == 0 || strlen($lastName) == 0 || !preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ-' ]+$/u", $firstName) || !preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ-' ]+$/u", $lastName)) {
        $error['errorMessage'] = "Enter your first- and lastname, start with capitals!";
    }
    return $error;
}

function checkEmail($email) {
    $error = [];
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error['errorMessage'] = "Provide a proper email address.";
    }
    return $error;    
}

function checkNumber($phone) {
    $error = [];
    if (strlen($phone) > 12 || substr($phone, 0, 2) !== '+1') {
        $error['errorMessage'] = "Phone number should be 12 characters long and start with '+1'.";
    }
    return $error;
}

function checkAddress($cityName, $areaName, $number) {
    $error = [];
    if(strlen($cityName) == 0 || !preg_match("/^[A-Z][a-zA-Z]*$/", $cityName)) {
        $error['errorMessage'] = "Enter your city, start with  a capitals!";
    } if(strlen($areaName) == 0 || !preg_match("/^[A-Z][a-zA-Z]*$/", $areaName)) {
        $error['errorMessage'] = "Enter your area name, start with  a capitals!";
    } if($number < 1) {
        $error['errorMessage'] = "Set your house number!";    
    }
    return $error;
}    

function checkPassword ($password1, $password2) {
    $error = [];
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=(.*\d){2,}).{8,}$/", $password1) || $password1 !== $password2) {
        $error['errorMessage'] = "Your password should be minimum 8 characters, have upper- and lowercase letters and two numbers. The two password must be the same.";
    }
    return $error;   
}

function addToCart($productId, $productBrand, $productModel, $productPrice) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_POST['addToCart'])) {
        $product = array("ID"=> $productId, "Brand"=>$productBrand, "Model"=>$productModel, "Price"=>$productPrice);
        array_push($_SESSION['cart'], $product);
        print("Product('s) added to your cart!");
    }     
}

function removeFromCart() {
    if (isset($_POST['remove'])) {
        $index = $_POST['remove'];
        unset($_SESSION['cart'][$index]);
        header("Location: shoppingcart.php");
    }
}

function clearCart() {
    if (isset($_POST['clear'])) {
        session_unset();
        session_destroy();
        header("Location: shoppingcart.php");
    }
}

function statusCheck() {
    if (isset($_POST['createOrder'])) {
        if(!isset($_SESSION['user_id'])) {
            print("<br>");
            print("You must be logged in to make an order.");
        }
    }
} 

function cartCheck() {
    if (isset($_POST['createOrder'])) {
        if (empty($_SESSION['cart'])) {
            print("<br>");
            print("Your cart must have at least one product to make an order.");
            print("<br>");
        }
        if (!empty($_SESSION['cart'])) {
            header("Location: order.php"); 
        } 
    }
}
?>