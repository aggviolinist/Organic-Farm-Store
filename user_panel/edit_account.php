<?php
include("../includes/connect.php");
if(isset($_GET['edit_account'])){
    $session_username = $_SESSION['username'];
    $select_query = "select * from `users` where username='$session_username'";
    $execute_select_query = mysqli_query($con,$select_query);
    $fetch_rows = mysqli_fetch_assoc($execute_select_query);
    $user_id = $fetch_rows['user_id'];
    $firstName = $fetch_rows['first_name'];
    $lastName = $fetch_rows['last_name'];
    $email = $fetch_rows['user_email'];
    $mobileNumber = $fetch_rows['mobile_number'];
    $addy = $fetch_rows['user_address'];
}
if(isset($_POST['update_user'])){
    $update_id = $user_id;
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email_hidden'];
    $mobileNumber = $_POST['mobileNumber'];
    $addy = $_POST['address'];

    //update query
    $update_data = "update `users` set first_name='$firstName',last_name='$lastName',user_email='$email',mobile_number='$mobileNumber',user_address='$addy' where user_id=$update_id";
    $execute_update_data = mysqli_query($con,$update_data);
    if($execute_update_data){
        echo "<script>alert('Data updated successfully')</script>";
       // echo "<script>window.open('../index.php','_self')</script>";
    }else{
        echo "<script>alert('Data not updated')</script>";

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 150px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2> <?php
        // Check if the user is logged in
        if(isset($_SESSION['username'])){
            $login_username = $_SESSION['username'];
            echo "<p style='color:#000000; font-size: 25px;'>Edit your account, $login_username!</p>";
        } else {
            // If not logged in, display the login button
            echo "<a style='text-decoration: none; color: #49beb7; font-size: 23px;' href='user_login.php'>Sign in</a>";      
        }
        ?></h2>
        <form id="updateForm" action=" " method="post">

            <label for="firstName">Username:</label>
            <input type="text" value="<?php echo $session_username ?>" name="firstName" disabled>

            <label for="firstName">First Name:</label>
            <input type="text" value="<?php echo $firstName ?>" name="firstName" required>

            <label for="lastName">Last Name:</label>
            <input type="text" value="<?php echo $lastName ?>" name="lastName" required>

            <label for="email">Email:</label>
            <input type="email" value="<?php echo $email ?>" name="email" disabled>
            <input type="hidden" name="email_hidden" value="<?php echo $email ?>">


            <label for="mobileNumber">Mobile Number:</label>
            <input type="tel" value="<?php echo $mobileNumber ?>" name="mobileNumber" pattern="[0-9]{10}" required>
            <small>Format: +2547xxxxxxx</small>
            <br>
            <br>
            <label for="address">Address:</label>
            <input type="text" value="<?php echo $addy ?>" name="address" rows="4" required>

            <button type="submit" name="update_user" >Update</button>
        </form>
    </div>

</body>
</html>
