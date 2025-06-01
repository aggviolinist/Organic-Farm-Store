<?php
include("../includes/connect.php");
//include("../includes/common_functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
</head>
<body>

    <form action="" method="post"> <!--we do not give action because we write the php code on the same php page not a different one -->
        <h2>Admin Registration</h2><!-- action should be a .php -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" autocomplete="off" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="off" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" autocomplete="off" required>

        <button type="submit" name="register_admin">Register</button>
        <p><strong>Already have an account?<a style="text-decoration: none; color:blue" href="admin_login.php">Login</a></strong></p>
    </form>
</body>
</html>
<?php
if(isset($_POST['register_admin'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $hash_password=password_hash($password,PASSWORD_DEFAULT);
    $confirm_password=$_POST['confirm_password'];

//confirming if the admin in the database exists
    $select_admin = "SELECT * from `admin` where admin_name='$username'";
    $execute_admin = mysqli_query($con,$select_admin);
    $count_rows = mysqli_num_rows($execute_admin);
    if($password!=$confirm_password){
        echo "<script>alert('Passwords do not match')</script>";
    }else if($count_rows==0){
        $insert_admin = "INSERT into `admin`(admin_name,admin_password)values('$username','$hash_password')";
        $execute_insert_admin = mysqli_query($con,$insert_admin);
        echo "<script>alert('Congratulations! Registration successful')</script>";
        echo "<script>window.open('admin.php','_self')</script>";

    }
    else{
        echo "<script>alert('Admin already exists')</script>";
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