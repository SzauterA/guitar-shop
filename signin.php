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
    <title>Signin page</title>
</head>
<body>
    <h1>Sign in</h1>
    <h2>Please fill in the fields below to register yourself.</h2>
    <form method="POST">
        <label>Firstname:</label>
        <input type="text" name="firstname">
        <label>Lastname:</label>
        <input type="text" name="lastname">
        <br>
        <label>Email:</label>
        <input type="email" name="email">
        <br>
        <label>Phone number:</label>
        <input type="tel" name='phonenumber'>
        <div>(Phone number should be 12 characters long and starts with +1.)</div>
        <label>Address:</label>
        <input type="text" name='city' placeholder="City">
        <input type="text" name='name' placeholder="Area name">
        <select id='type' name='type' placeholder="Area type" required>
            <option>Street</option>
            <option>Road</option>
            <option>Square</option>
            <option>Boulevard</option>
            <option>Avenue</option>
        </select>
        <input type='number' name='number' placeholder='House number' min='1'>
        <br>
        <label>Password:</label>
        <input type='password' name='password1'>
        <label>Password again:</label>
        <input type='password' name='password2'>
        <div>(Your password must be at least 8 characters long, contain upper- and lowercase letters as well, and have two numbers in it.)</div>
        <br>
        <button type="submit" name="submit">Sign in</button>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $firstName = $_POST["firstname"];
        $lastName = $_POST["lastname"]; 
        $email = $_POST["email"];
        $phone = $_POST["phonenumber"];
        $cityName = $_POST["city"];
        $areaName = $_POST["name"];
        $areaType = $_POST["type"];
        $number = $_POST["number"];
        $address = "$cityName, $areaName $areaType $number.";
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];

        $errors = [];

        $nameError = checkNames($firstName, $lastName);
        if (count($nameError) > 0) {
            $errors['name'] = $nameError;
        }
        $emailError = checkEmail($email);
        if (count($emailError) > 0) {
            $errors['email'] = $emailError;
        }
        $numberError = checkNumber($phone);
        if (count($numberError) > 0) {
            $errors['number'] = $numberError;
        }
        $addressError = checkAddress($cityName, $areaName, $number);
        if (count($addressError) > 0) {
            $errors['address'] = $addressError;
        }
        $passwordError = checkPassword($password1, $password2);
        if (count($passwordError) > 0) {
            $errors['password'] = $passwordError;
        }

        if (count($errors) === 0) {
            $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
            require_once './db_config.php';
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $stmt = mysqli_prepare($conn, "INSERT INTO customers(first_name, last_name, email, phone_number, address, password)
                    VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $email, $phone, $address, $hashedPassword);      
            if (mysqli_stmt_execute($stmt)) {
                print("Your registration was successful. Now you have an account.");
                header("Location: login.php");
                exit;
            } else {
                print("Error: " . $sql . "<br>" . mysqli_error($conn));
            } 
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            foreach ($errors as $error) {
                print_r($error['errorMessage']."<br>");
            }
        } 
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