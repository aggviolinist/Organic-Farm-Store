<?php
include('../includes/connect.php');
header("Content-Type: application/json");

$stkCallbackResponse = file_get_contents('php://input');
$res= json_decode($stkCallbackResponse, true);
$dataToLog = array(
    date("Y-m-d H:i:s"), //Date and time
    " MerchantRequestID: " . $res['Body']['stkCallback']['MerchantRequestID'],
    " CheckoutRequestID: " . $res['Body']['stkCallback']['CheckoutRequestID'],
    " ResultCode: " . $res['Body']['stkCallback']['ResultCode'],
    " ResultDesc: " . $res['Body']['stkCallback']['ResultDesc'],
);
$data = implode(" - ", $dataToLog);
$data .= PHP_EOL;
file_put_contents('transaction_log', $data, FILE_APPEND); //Logs the results to our log file

print($res['Body']['stkCallback']['ResultCode']);

if ($res['Body']['stkCallback']['ResultCode'] == '1032') {
    print('endpoint doesnt works');
    // $sql = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE order_no = :order_no");
    // $rs = $sql->execute(['order_no' => $orderNo]);
    // unset($_SESSION['orderNo']);
} else {
    print('endpoint works');
    // $sql = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE order_no = :order_no");
    // $rs = $sql->execute(['order_no' => $orderNo]);
    // unset($_SESSION['orderNo']);

}

if ($rs) {
    file_put_contents('error_log', "Records Inserted\n", FILE_APPEND);;
} else {
    file_put_contents('error_log', "Failed to insert Records\n", FILE_APPEND);
}


?> 