<?php
if(isset($_GET['delete_orders'])){
    $delete_orders = $_GET['delete_orders']; 
    
    $delete_orders_query = "DELETE from `user_orders` where order_id=$delete_orders";
    $execute_query = mysqli_query($con,$delete_orders_query);
    if($execute_query){
        echo "<script>alert('Order deleted successfully')</script>";
        echo "<script>window.open('./admin.php?view_orders','_self')</script>";
    }
}
?>