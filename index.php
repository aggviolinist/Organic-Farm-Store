<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>window.open('index.php','_self')</script>";
    exit();
}
include("./includes/connect.php");

include('functions/common_functions.php');
?>
<style>
body{
overflow-x: hidden;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Store</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">E-Farm Store</div>
            <ul>
                <li><a style="text-decoration:none" href="products.php">Products</a></li>
                <li><a style="text-decoration:none" href="cart.php">Cart</a></li>
                <?php
                // Check if the user is logged in
               if (isset($_SESSION['username'])) {
                echo "<li><a style='text-decoration:none' href='?logout=1' name='logout'>Sign Out</a></li>";
            } else {
                echo "<li><a style='text-decoration:none' href='user_panel/user_login.php'>Sign In</a></li>";
            }
             ?>
                <li><a style="text-decoration:none" href="#">About</a></li>
                <?php
                // Check if the user is logged in
               if (isset($_SESSION['username'])) {
                echo " <li><a style='text-decoration:none' href='user_panel/profile.php'>My Account</a></li>";
            } else {
                echo "<li><a style='text-decoration:none' href='user_panel/registration.php'>Register</a></li>";
            }
             ?>
            </ul>
            <div class="search-bar">
               <form method="get" action="search_product.php">
                <input type="text" placeholder="Search" name="search_products">
                <button type="submit" value="search" name="search_btn">Search</button>
               </form>
            </div>
        </nav>
    </header>
    
    <main>
        <section class="frame">
            <h1>Welcome to Our Farm Store</h1>
            <h3>Experience the freshness of farm produce.</h3>
        </section>
        <?php
        $ip = getIPAddress();  
        echo 'User Real IP Address - '.$ip;
        ?>
        <br>
        <?php
        $total_in_cart = cart_total();
         echo 'cart total - ' .$total_in_cart;
         ?>
    </main>
    <footer>
        <p>&copy; 2023 Farm Store</p>
    </footer>
</body>
</html>
