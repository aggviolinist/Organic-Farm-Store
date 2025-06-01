<?php
session_start();
include('../includes/connect.php');
//include('../functions/common_functions.php');
global $con;
if(isset($_GET['user_id'])){
    $user_id=$_GET['user_id'];
}

//getting total items and total price of all items
$get_ip_address = getIPAddress();
$total_price = 0;
$query_cart_price = "select * from `cart` where ip_address='$get_ip_address'";
$execute_cart_price = mysqli_query($con,$query_cart_price);
$invoice_number = mt_rand(); //php function to generate random integers
$status = 'pending';
$count_products = mysqli_num_rows($execute_cart_price);
while($row_price=mysqli_fetch_array($execute_cart_price)){
    $product_id = $row_price['product_id'];
    $select_product = "select * from `products` where product_id=$product_id";
    $get_cart_product = mysqli_query($con,$select_product);
    while($row_cart_product = mysqli_fetch_array($get_cart_product)){
        $product_price = array($row_cart_product['product_price']); //price is going to be stored in an array
        $product_sum_price = array_sum($product_price);
        $total_price += $product_sum_price;
    }

}
//getting quantity from cart
$get_cart = "select * from `cart`";
$execute_cart = mysqli_query($con,$get_cart);
$get_item_quantity = mysqli_fetch_array($execute_cart);
$quantity = $get_item_quantity['quantity'];
if($quantity==0){
    $quantity=1;
    $subtotal=$total_price;
}
else{
    $quantity=$quantity;
    $subtotal=$total_price*$quantity;
}

//inserting to users orders from cart
$insert_orders = "insert into `user_orders` (user_id,amount_due,invoice_number,total_products,order_date,order_status) values ($user_id,$subtotal,$invoice_number,$count_products,NOW(),'$status')";
$execute_insert_orders = mysqli_query($con,$insert_orders);
if($execute_insert_orders){
    echo "<script>alert('orders submitted successfully')</script>";
    echo "<script>window.open('profile.php','_self')</script>";
}

//inserting to pending orders from user orders
$insert_pending_orders = "insert into `pending_orders` (user_id,invoice_number,product_id,quantity,order_status) values ($user_id,$invoice_number,$product_id,$quantity,'$status')";
$execute_pending_orders = mysqli_query($con,$insert_pending_orders);

//deleting from cart after inserting to user orders and pending orders tables
$empty_cart = "delete from `cart` where ip_address='$get_ip_address'";
$execute_delete = mysqli_query($con,$empty_cart);

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
