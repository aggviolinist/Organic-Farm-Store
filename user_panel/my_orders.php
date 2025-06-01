<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .status-complete {
            color: green;
            font-weight: bold;
            text-decoration:none;
        }

        .status-incomplete {
            color: red;
            font-weight: bold;
            text-decoration:none;
        }
    </style>
    <title>User Orders</title>
</head>
<body>
    <?php
    $username_session = $_SESSION['username'];
    $get_users = "select * from `users` where username='$username_session'";
    $execute_get_users = mysqli_query($con,$get_users);
    $fetch_row = mysqli_fetch_assoc($execute_get_users);
    $user_id = $fetch_row['user_id'];
    ?>
    <h2>All Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Serial No</th>
                <th>Order No</th>
                <th>Amount Due</th>
                <th>Total Products</th>
                <th>Invoice No</th>
                <th>Date</th>
                <th>Complete/Incomplete</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $get_order_details = "select * from `user_orders` where user_id=$user_id";
            $execute_get_order_details = mysqli_query($con,$get_order_details);
            $s_number = 1;
            while( $user_row = mysqli_fetch_assoc($execute_get_order_details)){
                $order_no = $user_row['order_id'];
                $amount_due = $user_row['amount_due'];
                $total_products = $user_row['total_products'];
                $invoice_number = $user_row['invoice_number'];
                $date = $user_row['order_date'];
                $order_status = $user_row['order_status'];
                if($order_status=='pending'){
                    $order_status='Incomplete';
                }else{
                    $order_status='Complete';
                }
                echo "<tr>
                <td>$s_number</td>
                <td>$order_no</td>
                <td>$amount_due</td>
                <td>$total_products</td>
                <td>$invoice_number</td>
                <td>$date</td>
                <td>$order_status</td>";
                ?>
                <?php
                if($order_status=='Complete'){
                    echo "<td class='status-complete'>Paid</td>";
                }else{
                    echo "<td><a class='status-incomplete' href='confirm_payment.php?order_id=$order_no'>Confirm</a></td>
                    </tr>";
                }         
            $s_number++;
            }
            ?>
          
        </tbody>
    </table>

</body>
</html>
