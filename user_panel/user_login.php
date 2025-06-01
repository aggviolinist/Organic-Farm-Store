<?php
include("../includes/connect.php");
//include("../includes/common_functions.php");
@session_start(); //only starts when the page is active
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="user_login.css">
    <!-- <script defer src="user_login.js"></script> -->
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username_login" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password_login" required>
            </div>
            <div class="form-group">
                <button type="submit" name="login_btn">Login</button>
            </div>
        </form>
        <div class="forgot-register">
            <a href="#">Forgot Password?</a> | <a href="registration.php">Register</a>
        </div>
    </div>

    <!-- <script src="user_login.js"></script> -->
</body>
</html>

<?php

if(isset($_POST['login_btn'])){
    $login_username = $_POST['username_login'];
    $login_passwd = $_POST['password_login'];

    //fetching usernames from cart
    $select_login = "select * from `users` where username='$login_username'";
    $execute_select_login = mysqli_query($con,$select_login);
    $login_row_count = mysqli_num_rows($execute_select_login);
    $select_passwd = mysqli_fetch_assoc($execute_select_login); //we run an array to select only one section in the table that is the passwords
    //ipaddress of user
    $user_ip = getIPAddress();
    //fetching cart items
    $select_query = "select * from `cart` where ip_address='$user_ip'";
    $execute_query = mysqli_query($con,$select_query);
    $row_count_in_cart = mysqli_num_rows($execute_query);
      
    if($login_row_count>0){ //verifying passwords
        $_SESSION['username']=$login_username;
        if(password_verify($login_passwd,$select_passwd['user_password'])){
            if($login_row_count==1 and $row_count_in_cart==0){ //if user is logged in and has nothing in cart
            $_SESSION['username']=$login_username; //starting a session
            echo "<script>alert('Sign In successfully')</script>";
            echo "<script>window.open('../products.php','_self')</script>";
            }
            else{
            $_SESSION['username']=$login_username;
            echo "<script>alert('Sign In successfully')</script>";
            echo "<script>window.open('payment.php','_self')</script>";
            }
        }
        else{
            echo "<script>alert('Invalid credentials')</script>";
        }

    }
    else{
        echo "<script>alert('Invalid credentials!!')</script>";
    }
}

function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
?>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f3f3f3;
    margin: 0;
    padding: 0;
    display: flex; /*creating equal columns */
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* represents a percentage of the height of the viewport, which is the visible area of a web page in the browser window.*/
}

.login-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* subtle, slightly blurred shadow with no horizontal or vertical offset to the element, semi-transparent due to the alpha value of 0.2 */
    text-align: center;
    max-width: 400px;
}

.login-container h1 {
    color: #333;
    margin-bottom: 20px;
}

.form-group {
    text-align: left;
    margin: 10px 0;
}

label {
    display: block;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.forgot-register {
    margin-top: 20px;
}

a {
    text-decoration: none;
    color: #4CAF50;
    font-weight: bold;
}
</style>

