<?php
session_start();
include('../includes/connect.php');
//include('../functions/common_functions.php');

global $con;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
</head>
<body>
<?php
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
    $user_ip=getIPAddress();
    $select_user = "select * from `users` where user_ip_address='$user_ip'";
    $exeute_query = mysqli_query($con,$select_user);
    $run_query = mysqli_fetch_array($exeute_query);
    $user_id = $run_query['user_id'];
?>
<header>
    <div class="navbar">
        <h1>Place Order</h1>
    </div>
</header>
<div class="checkout-container">
    <h2>Checkout</h2>
    <form action="#" method="post">
        <!-- Billing Information -->
        <h3>Payment Methods</h3>
        <!-- Payment Options -->

<div class="payment-options">
  <!-- <div class="payment-option">
    <a href="https://www.jumia.co.ke/" target="_blank" style="text-decoration:none;">
      <input type="radio" id="mpesa" name="payment" value="mpesa" required>
      <label for="mpesa">M-Pesa</label>
      <img style="width: 80px; height: 40px;" src='user_images/mpesa.png' alt='mpesa'>
    </a>
  </div> -->
  <br>
  <!-- <div class="payment-option">
    <a href="https://www.jumia.co.ke/" target="_blank" style="text-decoration:none;">
      <input type="radio" id="bitcoin" name="payment" value="bitcoin" required>
      <label for="bitcoin">Bitcoin</label>
      <img style="width: 70px; height: 60px;" src='user_images/Bitcoin.png' alt='btc'>
    </a>
  </div> -->
  <br>

  <!-- <div class="payment-option">
    <a href="https://www.jumia.co.ke/" target="_blank" style="text-decoration:none;">
      <input type="radio" id="ethereum" name="payment" value="ethereum" required>
      <label for="ethereum">Ethereum</label>
      <img style="width: 70px; height: 70px;" src='user_images/ethereum.png' alt='eth'>
    </a>
  </div>
   -->
  <br>
  <div class="payment-option">
    <a href="order.php?user_id=<?php echo $user_id ?>" style="text-decoration:none;">
      <input type="radio" id="offline" name="payment" value="offline" required>
      <label for="offline">mpesa</label>
      <img style="width: 70px; height: 70px;" src='user_images/mpesa.png' alt='off'>
    </a>
  </div>
  
  <br>
</div>
        <!-- <?php
            if(!isset($_SESSION['username'])){
                //include('user_login.php');
                echo "<script>window.open('user_login.php','_self')</script>";

            }
            else{
                // include('payment.php');
                echo "<script>window.open('payment.php','_self')</script>";
            }
        ?> -->

        <button type="submit">Proceed to Payment</button>
    </form>
</div>

</body>
</html>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh;
    background: linear-gradient(45deg, #3498db, #2c3e50); 
}

header {
    background-color: #333;
    padding: 15px;
    text-align: center;
}

header h1 {
    color: #fff;
    margin: 0;
}

.checkout-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    margin: 20px auto;
}

.payment-options {
    display: flex;
    flex-direction: column;
    margin-top: 20px;
}

.payment-option {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.payment-option img {
    margin-left: 10px;
    object-fit: contain;
}

button {
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>