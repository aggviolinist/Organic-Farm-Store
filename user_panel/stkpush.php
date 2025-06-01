<?php 
include('../includes/connect.php');

session_start();

$order_id = $_SESSION['orderId'];

$config = array(
    "env"              => "sandbox",
    "BusinessShortCode"=> "174379",
    "key"              => "Nc89cErjGG7W3Y1OEEFbSktrVbkUGmwc",
    "secret"           => "5loxc6QBnRe1QYlM",
    "TransactionType"  => "CustomerPayBillOnline",
    "passkey"          => "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919",
    "CallBackURL"      => "https://75de-105-161-90-153.ngrok-free.app/FarmStore/user_panel/callback.php", //When using localhost, Use Ngrok to forward the response to your Localhost
    "AccountReference" => "Green garden farms",
    "TransactionDesc"  => "Payment",
);
if(isset($_POST['payment_btn'])){
    $query_select_user_data_from_user_orders="select user_id from `user_orders` where order_id=$order_id";
    $execute_user_data_from_user_orders = mysqli_query($con,$query_select_user_data_from_user_orders);
    $result_user_data_from_user_orders = mysqli_fetch_assoc($execute_user_data_from_user_orders);
  
    $user_id = $result_user_data_from_user_orders['user_id'];
   
    $query_select_mobile_number_from_user_data="select mobile_number from `users` where user_id=$user_id";
    $execute_select_mobile_number_from_user_data = mysqli_query($con,$query_select_mobile_number_from_user_data);
    $result_select_mobile_number_from_user_data = mysqli_fetch_assoc($execute_select_mobile_number_from_user_data);
    $mobileNo= $result_select_mobile_number_from_user_data['mobile_number'];
  
    $phone = '254' . ltrim($mobileNo, '0');
    $invoice_number = $_POST['invoice_no_hidden'];
    $amount = 1; //dummy amount
    // Uncomment the below when going live or wanting to pay 4 exact amount
    // $amount = $_POST['amount_due_hidden'];
    $payment_method = $_POST['payment_method'];
  
    $access_token = ($config['env']  == "live") ? "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials" : "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials"; 
    $credentials = base64_encode($config['key'] . ':' . $config['secret']); 

    
    $ch = curl_init($access_token);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $credentials]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response); 
    $token = isset($result->{'access_token'}) ? $result->{'access_token'} : "N/A";

    $timestamp = date("YmdHis");
    $password  = base64_encode($config['BusinessShortCode'] . "" . $config['passkey'] ."". $timestamp);

    $curl_post_data = array( 
        "BusinessShortCode" => $config['BusinessShortCode'],
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => $config['TransactionType'],
        "Amount" => $amount,
        "PartyA" => $phone,
        "PartyB" => $config['BusinessShortCode'],
        "PhoneNumber" => $phone,
        "CallBackURL" => $config['CallBackURL'],
        "AccountReference" => $config['AccountReference'],
        "TransactionDesc" => $config['TransactionDesc'],
    ); 

    $data_string = json_encode($curl_post_data);

//mpesa express end point
    $endpoint = ($config['env'] == "live") ? "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest" : "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest"; 


    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer '.$token,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);


    $result = json_decode($response, true);
//0 == successful
//1 == unsuccessful
//1032 == error in daraja

    if (isset($result['ResponseCode']) && $result['ResponseCode'] === "0") 
    {         //STK Push request successful

        $MerchantRequestID = $result['MerchantRequestID'];
        $CheckoutRequestID = $result['CheckoutRequestID'];

        $sql = "INSERT INTO `stk_transactions`(`order_no`, `amount`, `phone`, `CheckoutRequestID`, `MerchantRequestID`) VALUES ('".$_SESSION['orderId']."','".$amount."','".$phone."','".$CheckoutRequestID."','".$MerchantRequestID."');";

       $exec=  mysqli_query($con,$sql);
       if($exec){
        echo "<script>alert('Payment successful.')</script>";
        echo "<script>window.open('profile.php?my_orders','_self')</script>";

    }
    //updating the status to complete
    //$update_orders="update `user_orders` set order_status='Complete' where order_id=$order_id ";
    //$execute_update_query=mysqli_query($con,$update_orders);

       if ($exec) {
        // Query was successful, fetch the result
        $result_exec = mysqli_fetch_assoc($exec);
    } else {
        // Query failed, handle the error
        echo "Error executing query: " . mysqli_error($con);
        echo "SQL Query: " . $sql;
    }
      // $result_exec = mysqli_fetch_assoc($exec);
  
        // header('location: order.php');

    }else{
        $warning_msg[] = $result['errorMessage'];
    }
}
