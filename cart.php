<?php
session_start();
if (isset($_GET['logout3'])) {
    session_destroy();
    echo "<script>window.open('index.php','_self')</script>";
    exit();
}
include('includes/connect.php');
include('functions/common_functions.php');

global $con;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <?php
    //search_product();
    ?>
<nav>
<div style=" float: left; margin-left: 20px; line-height: 50px;" class="user-section">
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            $switch_username = $_SESSION['username'];
            echo "<p style='color:#000000; font-size: 25px;' >Hi, $switch_username!</p>";
        } else {
            // If not logged in, display the login button
            echo "<svg xmlns='viewBox='0 0 16 16' width='16' height='16'><path d='M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm.847-8.145a2.502 2.502 0 1 0-1.694 0C5.471 8.261 4 9.775 4 11c0 .395.145.995 1 .995h6c.855 0 1-.6 1-.995 0-1.224-1.47-2.74-3.153-3.145Z'></path></svg>
            <a style='text-decoration: none; color: #49beb7; font-size: 25px;' href='user_panel/user_login.php'>Sign in</a>";
      
        }
        ?>
    </div>
        <ul>
            <li><a style="text-decoration:none" href="products.php">Vegetables</a></li>
            <li><a style="text-decoration:none" href="products.php">Fruits</a></li>
            <li><a style="text-decoration:none" href="products.php">Chicken & Eggs</a></li>
            <li><a style="text-decoration:none" href="products.php">Honey</a></li>
            <li><a style="text-decoration:none" href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg><sup style="font-size:22px;color: black;";><?php no_items_in_cart() ?></sup></a></li>
            <li><a style="text-decoration:none" href="user_panel/profile.php">My Account</a></li>
        </ul>
        <div class="search-bar">
            <form method="get" action=" ">
            <input type="text" placeholder="Search" name="search_products">
            <button style='cursor: pointer;' type="submit" value="search" name="search_btn">search</button>
            </form>          
        </div>
        <div class="search-bar" style='margin-bottom:50px;'>
        <a href="?logout3=1"><button style='color:#000000; float: left; cursor: pointer;' type="submit" value="logout3" name="logout3">Log out</button></a>    
        </div>
    </nav>
    <div class="cart">
        <h1>Shopping Cart</h1>
        <form action="" method="post">
        <?php

global $con; //variable is on another page so global makes it accesssible
$total = 0;
$get_ip_addy = getIPAddress();
$count_cart = "select * from `cart` where ip_address='$get_ip_addy'";
$execute_count_cart = mysqli_query($con,$count_cart); 
//$result_count = mysqli_num_rows($execute_product_query);
if(mysqli_num_rows($execute_count_cart) == 0){
    echo "<h2 style='text-align:center; color:red';>cart is empty</h2>";
}
while($cart_rows = mysqli_fetch_array($execute_count_cart)){
    $product_id = $cart_rows['product_id'];
    $select_product_query = "select * from `products` where product_id='$product_id'";
    $execute_product_query = mysqli_query($con,$select_product_query);
    while($cart_products_price = mysqli_fetch_array($execute_product_query)){
        $product_array_price = array($cart_products_price['product_price']);
        $product_price_on_cart = $cart_products_price['product_price'];
        $product_name = $cart_products_price['product_name'];
        $product_description = $cart_products_price['product_description'];
        $product_image = $cart_products_price['product_image'];
        $total_product_price = array_sum($product_array_price);
        $total += $total_product_price;
        ?>  
            
        <div class="cart-item">
            <img src="admin_panel/product_images/<?php echo $product_image ?>" alt="Product image">
            <div class="item-details">
                <h2><?php echo $product_name ?></h2>
                <p><?php echo $product_description ?></p>
            </div>
            <div class="item-quantity">
                <input type="button" name ="decrease_product" size="3" onclick="decrementValue(<?php echo $product_id; ?>)" value="-"/>
                <input type="text" name="qty[<?php echo $product_id; ?>]" value="1" maxlength="2" max ="10" size= "1" id="number<?php echo $product_id; ?>" value='<?php echo $_SESSION["quantity"];?>' />
                <?php
               $get_ip_address = getIPAddress();
               if(isset($_POST['update_cart'])){
                   $new_quantity = $_POST['qty'];
                   foreach ($_POST['qty'] as $product_id => $new_quantity) {
                   $update_cart = "update `cart` set quantity=$new_quantity where ip_address='$get_ip_address'";
                   $execute_quantity = mysqli_query($con,$update_cart);
                   $total = $total*$new_quantity;
                   }
                }
        
        ?>
                <input type="button" name ="increase_product" onclick="incrementValue(<?php echo $product_id; ?>)" value="+"/>
                </div>       
            <p class="item-price">ksh <?php echo $product_price_on_cart ?>.00</p>
            <button name="remove_item[<?php echo $product_id ?>]" value="<?php echo $product_id ?>" class="remove-button">Remove</button>
        </div> 
        <?php
    }}
        ?>
        <!-- Total -->
        <?php
        if(mysqli_num_rows($execute_count_cart) > 0){
        echo "<div class='cart-total'>
        <p>Total: <span class='total'>ksh $total.00</span></p>
        </div>
        <button class='update-button' name='update_cart'>update cart</button>
        <br>
        <a style='text-decoration:none' href='products.php'>continue shopping</a></li>
       <a style='text-decoration:none' href='./user_panel/checkout.php'><button name='check_out' class='checkout-button'>Checkout($total)</button></a> ";
        }
        else
        {
           echo "<a style='text-decoration:none' href='products.php'>continue shopping</a></li>";
        }
        if(isset($_POST['check_out'])){
            echo "<script>window.open('./user_panel/checkout.php','_self')</script>";
        }
        
        ?>
    </div>
    </form>
    <?php
  //  function remove_item(){      
        global $con;
        if(isset($_POST['remove_item'])){
        foreach($_POST['remove_item'] as $product_id_to_remove){
        $delete_query = "DELETE FROM `cart` WHERE product_id='$product_id_to_remove'";
        $execute_delete_query = mysqli_query($con, $delete_query);
        if($execute_delete_query){
            echo "<script>window.open('cart.php','_self')</script>";
        } else {
            echo '<script>alert("Product not deleted from cart")</script>';
        }
    }
}

   // }
    ?>
</body>
</html>
<script type="text/javascript">
  function incrementValue(productId){          
    var value = parseInt(document.getElementById('number' + productId).value,10);
    value = isNaN(value) ? 0 : value;//NaN function checks if the value is not a number
    if(value<10){
        value ++;
        document.getElementById('number' + productId).value = value;
        }
        }
    function decrementValue(productId){
    var value = parseInt(document.getElementById('number' + productId).value, 10);// returns an Element object representing the element whose id property matches the specified string.
    value = isNaN(value) ? 0 : value;
    if(value>1){
    value --;
    document.getElementById('number' + productId).value = value;
    }
    }
</script>