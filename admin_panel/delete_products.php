<?php
if(isset($_GET['delete_product'])){
    $delete_id = $_GET['delete_product']; 
    
    $delete_product = "DELETE from `products` where product_id=$delete_id";
    $execute_query = mysqli_query($con,$delete_product);
    if($execute_query){
        echo "<script>alert('Product deleted successfully')</script>";
        echo "<script>window.open('./admin.php?view_goods','_self')</script>";
    }
}
?>