<?php
include("../includes/connect.php");
//include("../includes/common_functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registration.css">
    <script defer src="registration.js"></script>
    <title>Farm User Registration</title>
</head>
<body>
    <div class="container">
    <h1>Registration</h1>
        <form action="" method="post" id="registrationForm" onsubmit="validateForm()" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" autocomplete="off" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" autocomplete="off" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your user name" autocomplete="off" required>

            <label for="user_email">Email:</label>
            <input type="email" id="user_email" name="user_email" placeholder="Enter your email" autocomplete="off" required>

            <label for="user_password">Password:</label>
            <input type="password" id="user_password" name="user_password" placeholder="Enter your password" autocomplete="off" required>
            <label >(password must be 8 characters, 1 uppercase, 1 special character, 1 number) </label>

            <label for="confirm_password">Confirm Password:</label>
            <input type="confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm password" autocomplete="off" required>

            <label for="mobile_number">Mobile Number:</label>
            <input type="tel" id="mobile_number" name="mobile_number" pattern="[0-9]{10}" placeholder="Enter your mobile number" autocomplete="off" required>
            <small>Format: +2547xxxxxxx</small>


            <label for="user_address">Location:</label>
            <textarea id="user_address" name="user_address" placeholder="Enter your location" autocomplete="off" required></textarea>

            <!-- <label for="user_image">Profile Image: </label>
            <input type="file" id="user_image" name="user_image" required> -->

            <button type="submit" name="user_registration">Register</button>
            <p><strong>Already have an account?<a style="text-decoration: none; color:blue" href="user_login.php">   Login</a> </strong></p>
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['user_registration'])){

    $f_name=$_POST['first_name'];
    $l_name=$_POST['last_name'];
    $user_name=$_POST['username'];
    $email=$_POST['user_email'];
    $password=$_POST['user_password'];
    $hash_password=password_hash($password,PASSWORD_DEFAULT);
    $confirm_password=$_POST['confirm_password'];
    $telephone=$_POST['mobile_number'];
    $ip_address=getIPAddress();
    $location=$_POST['user_address'];
    // $image=$_FILES['user_image']['name'];
    // $image_tmp = $_FILES['user_image']['tmp_name'];
    // $folder = "./user_images/" . $image;

//confirming if the user in the database exists
    $select_user = "select * from `users` where user_email='$email' or username='$user_name'";
    $execute_user = mysqli_query($con,$select_user);
    $count_rows = mysqli_num_rows($execute_user);
    if($password!=$confirm_password){
        echo "<script>alert('Passwords do not match')</script>";
    }else if($count_rows==0){
       // move_uploaded_file($image_tmp,$folder);
        $insert_user = "insert into `users`(first_name,last_name,username,user_email,user_password,mobile_number,user_ip_address,user_address)values('$f_name','$l_name','$user_name','$email','$hash_password','$telephone','$ip_address','$location')";
        $execute_insert_user = mysqli_query($con,$insert_user);
        echo "<script>alert('Congratulations. Registration successful')</script>";

    }
    else{
        echo "<script>alert('User already exists')</script>";
    }
    
    //selecting cart items
    $selecting_cart_items = "select * from `cart` where ip_address='$ip_address'";
    $execute_cart_items = mysqli_query($con,$selecting_cart_items);
    $counting_rows = mysqli_num_rows($execute_cart_items);
    if($counting_rows>0){
        $_SESSION['username']=$user_name; //starting a session
        echo "<script>alert('There are items in your cart')</script>";
        echo "<script>window.open('checkout.php','_self')</script>";
    }else{
        echo "<script>window.open('../products.php','_self')</script>";
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