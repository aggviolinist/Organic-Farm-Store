<?php
if(isset($_GET['delete_payments'])){
    $delete_payments = $_GET['delete_payments']; 
    
    $delete_payment_query = "DELETE from `payments` where payment_id=$delete_payments";
    $execute_query = mysqli_query($con,$delete_payment_query);
    if($execute_query){
        echo "<script>alert('Payment deleted successfully')</script>";
        echo "<script>window.open('./admin.php?view_payments','_self')</script>";
    }
}
?>