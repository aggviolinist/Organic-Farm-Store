<?php
if(isset($_GET['delete_users'])){
    $delete_users = $_GET['delete_users']; 
    
    $delete_users_query = "DELETE from `users` where user_id=$delete_users";
    $execute_query = mysqli_query($con,$delete_users_query);
    if($execute_query){
        echo "<script>alert('User deleted successfully')</script>";
        echo "<script>window.open('./admin.php?view_users','_self')</script>";
    }
}
?>