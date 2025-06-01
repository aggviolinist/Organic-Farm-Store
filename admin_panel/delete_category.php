<?php
if(isset($_GET['delete_category'])){
    $delete_id = $_GET['delete_category'];    
    $delete_cat = "DELETE from `category` where category_id=$delete_id";
    $execute_query = mysqli_query($con,$delete_cat);
    if($execute_query){
        echo "<script>alert('Category deleted successfully')</script>";
        echo "<script>window.open('./admin.php?view_cat','_self')</script>";
    }
}
?>