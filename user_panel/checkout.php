<?php
include('../includes/connect.php');
//include('../functions/common_functions.php');
global $con;
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="user_login.css">
</head>
<header>
<h1>Checkout</h1>
</header>
<body>
        <?php
            if(!isset($_SESSION['username'])){
               // include('user_login.php');
               echo "<script>window.open('user_login.php','_self')</script>";

            }
            else{
               // include('payment.php');
              echo "<script>window.open('payment.php','_self')</script>";
            }
        ?>
</body>
</html>

<style>
    header {
    background-color: #333;
    padding: 15px;
    text-align: center;
    position: fixed; /* Fixed positioning */
    top: 0; /* Stick to the top */
    width: 100%; /* Full width */
    z-index: 1000; /* Ensure it appears above other elements */
}

header h1 {
    color: #fff;
    margin: 0;
}
</style>
