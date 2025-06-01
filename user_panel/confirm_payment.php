<?php
session_start();
include('../includes/connect.php');
// include('stkpush.php');
global $con;

$order_id =  $_GET['order_id'];

$_SESSION['orderId'] = $order_id;

if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];

    $select_data="select * from `user_orders` where order_id=$order_id";
    $execute_select_data = mysqli_query($con,$select_data);
    $fetch_row = mysqli_fetch_assoc($execute_select_data);
    $invoice_no = $fetch_row['invoice_number'];
    $total_amount_due = $fetch_row['amount_due'];
}
if(isset($_POST['payment_btn'])){
  $invoice_number = $_POST['invoice_no_hidden'];
  $amount = $_POST['amount_due_hidden'];
  $payment_method = $_POST['payment_method'];

  $insert_query = "insert into `payments` (order_id,invoice_number,amount,payment_method) values ($order_id,$invoice_number,$amount,'$payment_method')";
  $execute_query = mysqli_query($con,$insert_query);

  if($execute_query){
      echo "<script>alert('Payment successful.')</script>";
      echo "<script>window.open('profile.php?my_orders','_self')</script>";

  }
  //updating the status to complete
  $update_orders="update `user_orders` set order_status='Complete' where order_id=$order_id ";
  $execute_update_query=mysqli_query($con,$update_orders);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Payment</title>
</head>
<body>
  <div class="payment-container">
    <h2>Confirm Payment</h2>
    <form action="stkpush.php" method="post">
      <label for="invoice_no">Invoice Number:</label>
      <input type="text"  name="invoice_no" value="<?php echo $invoice_no ?>" disabled>
      <input type="hidden" name="invoice_no_hidden" value="<?php echo $invoice_no ?>">

      <label for="total_amount_due">Total Amount:</label>
      <input type="text" name="total_amount_due" value="<?php echo $total_amount_due ?>" disabled >
      <input type="hidden" name="amount_due_hidden" value="<?php echo $total_amount_due ?>">


      <label for="payment_method">Payment Method:</label>
      <select name="payment_method" required>
        <option value="mpesa">M-Pesa</option>
        <!-- <option value="bank">Bank Transfer</option> -->
        <option value="cod">Cash on Delivery</option>
      </select>

      <button type="submit" name="payment_btn">Confirm Payment</button>
    </form>
  </div>
</body>
</html>


<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .payment-container {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 400px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    input,
    select {
      width: 80%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    button {
      background-color: #4caf50;
      color: #fff;
      padding: 8px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }
  </style>