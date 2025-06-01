<?php
session_start();
if (isset($_GET['logout_admin'])) {
    session_unset();
    session_destroy();
    echo "<script>window.open('../index.php','_self')</script>";
    exit();
}
include('../includes/connect.php');
//include('../functions/common_functions.php');
global $con;
if (!isset($_SESSION['admin_username'])) {
    header('Location: admin_login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <nav>
        <div class="admin-welcome">Welcome, Admin</div>
        <ul class="admin-menu">
            <li><a href="admin.php?insert_category">Insert Category</a></li> <!-- ?insert_category is a get variable -->
            <li><a href="admin.php?insert_goods">Insert Products</a></li>
            <li><a href="admin.php?view_goods">View Products</a></li>
            <li><a href="admin.php?view_cat">View Category </a></li>
            <li><a href="admin.php?view_orders" >All Orders</a></li>
            <li><a href="admin.php?view_payments" >All Payments</a></li>
            <li><a href="admin.php?view_users" >List Users</a></li>
            <!--logout logic-->
            <li><a href="?logout_admin=1" name="logout">Logout</a></li>
            <!-- <a href="?logout=1"><button style='color:#000000; float: left; cursor: pointer;' type="submit" value="logout" name="logout">Log out</button></a>     -->

        </ul>
    </nav>
    <main>
        <!-- Content of admin panel will be displayed here -->
        <div>
            <?php
            //if this get variable ?insert_category is active include it in these pages
            if(isset($_GET['insert_category'])){
                include('insert_category.php');
            }
            if(isset($_GET['insert_goods'])){
                include('insert_products.php');
            }
            if(isset($_GET['view_goods'])){
                include('view_products.php');
            }
            if(isset($_GET['edit_goods'])){
                include('edit_product.php');
            }
            if(isset($_GET['delete_product'])){ 
                include('delete_products.php');
            }
            if(isset($_GET['view_cat'])){
                include('view_category.php');
            }
            if(isset($_GET['delete_category'])){
                include('delete_category.php');
            }
            if(isset($_GET['edit_category'])){
                include('edit_category.php');
            }
            if(isset($_GET['view_orders'])){
                include('view_orders.php');
            }
            if(isset($_GET['delete_orders'])){
                include('delete_orders.php');
            }
            if(isset($_GET['view_payments'])){
                include('view_payments.php');
            }
            if(isset($_GET['delete_payments'])){
                include('delete_payments.php');
            }
            if(isset($_GET['view_users'])){
                include('view_users.php');
            }
            if(isset($_GET['delete_users'])){
                include('delete_users.php');
            }            
            ?>
        </div>
    </main>
</body>
</html>
 <!-- When a different page is being displayed on index page we use GET variable and POST method  -->
  <!-- GET variable is used to access a specific page and include it to be displayed in index pqge  -->

<!-- POST method and "isset" are used when we want to fetch data from form by clicking on a button -->
