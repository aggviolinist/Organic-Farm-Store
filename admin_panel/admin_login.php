<?php
include("../includes/connect.php");
@session_start(); //only starts when the page is active
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>

    <form action="" method="post">
        <h2>Admin Login</h2>

        <label for="admin_username">Username:</label>
        <input type="text" id="admin_username" name="admin_username" autocomplete="off" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="admin_login">Login</button>
        <p><strong>Don't have an account?<a style="text-decoration: none; color:blue" href="admin_registration.php">Register</a></strong></p>
    </form>
</body>
</html>
<?php

if(isset($_POST['admin_login'])){
    $admin_username = $_POST['admin_username'];
    $admin_passwd = $_POST['password'];

    //fetching admin username from admin
    $select_login = "SELECT * FROM `admin` WHERE admin_name='$admin_username'";
    $execute_select_login = mysqli_query($con, $select_login);
    $admin_row_count = mysqli_num_rows($execute_select_login);

    if($admin_row_count > 0){ //verifying passwords
        $select_passwd = mysqli_fetch_assoc($execute_select_login);
        $_SESSION['admin_username'] = $admin_username;

        if(password_verify($admin_passwd, $select_passwd['admin_password'])){
            if($admin_row_count == 1){ //if user is logged in 
                echo "<script>alert('Sign In successfully')</script>";
                echo "<script>window.open('admin.php','_self')</script>";
            } else {
                echo "<script>alert('Invalid credentials!!')</script>";
            }
        } else {
            echo "<script>alert('Invalid credentials!!')</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials!!')</script>";
    }
}
?>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            max-width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }
</style>