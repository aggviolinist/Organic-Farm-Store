<?php
include('../includes/connect.php');
  $select_users_query = "SELECT * FROM `users`";
  $result_users = mysqli_query($con, $select_users_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
</head>
<body>
<h1 class="heading">View Users</h1>
    <table>
        <thead>
            <?php
            $count_users_rows=mysqli_num_rows($result_users);            
            ?>
        </thead>
        <tbody>
            <?php
            if($count_users_rows==0){
                echo "<tr><td colspan='7' class='no-orders'><h2>No users yet</h2></td></tr>";

            }
            else{
                echo "<tr>
            <th>S/Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>Delete</th>
            </tr>";
                $number=0;
                while ($fetch_row = mysqli_fetch_assoc($result_users)) {
                    $number++;
                    echo "<tr>";
                    echo "<td>" . $number . "</td>";
                    echo "<td>" . $fetch_row['first_name'] . "</td>";
                    echo "<td>" . $fetch_row['last_name'] . "</td>";
                    echo "<td>" . $fetch_row['username'] . "</td>";
                    echo "<td>" . $fetch_row['user_email'] . "</td>";
                    echo "<td>" . $fetch_row['mobile_number'] . "</td>";
                    echo "<td>" . $fetch_row['user_address'] . "</td>";
                    echo "<td><a href='admin.php?delete_users=$fetch_row[user_id]'><svg xmlns='http://www.w3.org/2000/svg' height='24' width='21' viewBox='0 0 448 512'><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg></a></td>";
                    echo "</tr>";
                }                
            }
            ?>   
        </tbody>
    </table>
</body>
</html>


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
            background-color: #7dd87d;
        }

        .status-complete {
            color: green;
            font-weight: bold;
            text-decoration: none;
        }

        .status-incomplete {
            color: red;
            font-weight: bold;
            text-decoration: none;
            
        }
        .heading {
             text-align: center;
             background-color: #4CAF50;
             color: white;
             padding: 20px 0;
        }
        .no-orders {
         border: none; /* Remove the border */
         padding: 0;   /* Remove padding, if needed */
}
    </style>