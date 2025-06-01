<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    echo "<script>window.open('../index.php','_self')</script>";
    exit();
}
include('../includes/connect.php');
//include('../functions/common_functions.php');
global $con;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #eee;
            width: 200px;
            padding: 10px;
            height: 100vh;
            position: fixed;
            top: 30;
            left: 0;
        }

        main {
            margin-top: 60px; 
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;   
        }

        nav a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #333;
            padding: 8px;
            border-radius: 5px;
            background-color: #ddd;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #bbb;
        }

        #orders {
            display: block;
        }
    </style>
</head>
    <header>
        <h1>User Profile</h1>
    </header>
    <nav>
        <?php
        // Check if the user is logged in
        if(isset($_SESSION['username'])){
            $login_username = $_SESSION['username'];
            echo "<p style='color:#000000; font-size: 25px;'>Hi, $login_username!</p>";
        } else {
            // If not logged in, display the login button
            echo "<svg xmlns='viewBox='0 0 16 16' width='16' height='16'><path d='M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm.847-8.145a2.502 2.502 0 1 0-1.694 0C5.471 8.261 4 9.775 4 11c0 .395.145.995 1 .995h6c.855 0 1-.6 1-.995 0-1.224-1.47-2.74-3.153-3.145Z'></path></svg>
                  <a style='text-decoration: none; color: #49beb7; font-size: 23px;' href='user_login.php'>Sign in</a>";      
        }
        ?>
        <a href="../products.php" >Back Shopping</a>
        <a href="profile.php?edit_account">Edit Account</a>
        <a href="profile.php?my_orders">My Orders</a>
        <a href="profile.php?pending_orders">Pending Orders</a>
        <a href="profile.php?delete_account">Delete Account</a>
        <a href="?logout=1" name="logout">Logout</a>
    </nav>
    <body>
    <main>
        <div>
            <?php
             if (isset($_GET['pending_orders'])) {
             get_user_order_details();
            }
            if (isset($_GET['edit_account'])) {
               
                include('edit_account.php');               
            }
            if (isset($_GET['my_orders'])) {
               
                include('my_orders.php');               
            }
            if (isset($_GET['delete_account'])) {
               
                include('delete_account.php');               
            }
            ?>
            <!-- Content of the orders goes here -->
            <!-- <h2>My Orders</h2>
            <p>Order 1: Product A</p>
            <p>Order 2: Product B</p> -->
            <!-- Add more order details as needed -->
        </div>
    </main>
</body>
</html>
<?php
//get user order details
function get_user_order_details(){
    global $con;
    $login_username = $_SESSION['username'];
    $get_details = "select * from `users` where username='$login_username'";
    $execute_get_details = mysqli_query($con,$get_details);
    while($query_row=mysqli_fetch_array($execute_get_details)){
        $user_id = $query_row['user_id'];
        $get_order = "select * from `user_orders` where user_id=$user_id and order_status='pending'";
        $execute_get_order = mysqli_query($con,$get_order);
        $row_count = mysqli_num_rows($execute_get_order);
        if($row_count > 0){
            echo "<h3> You have <span>$row_count</span> pending orders</h3>";
        }else{
            echo "<h3> You dont have any orders </h3> <a style='text-decoration: none; color: #ff0000; font-size: 25px;' href='../products.php'>Back shopping</a>";
        }
    }
}
?>
