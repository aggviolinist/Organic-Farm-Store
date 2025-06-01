<?php
include('../includes/connect.php');
  $select_products_query = "SELECT * FROM `category`";
  $result_products = mysqli_query($con, $select_products_query);
?>

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
           /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            z-index: 1;
        }

        /* Styles for the overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        /* Styles for the button */
        .open-modal-button {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        /* Close button inside the modal */
        .close-modal-button {
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        /* Styles for the Yes and No buttons */
        .modal-buttons {
            text-align: center;
            margin-top: 20px;
        }

        .modal-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .modal-buttons button.yes {
            background-color: #28a745;
            color: #fff;
        }

        .modal-buttons button.no {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
    <title>View Products</title>
</head>
<body>
<h1 class="heading">View Farm Products</h1>
    <table>
        <thead>
            <tr>
                <th>Category Number</th>
                <th>Category Name</th>
                <th>Category Description</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $number = 0;
            while ($fetch_row = mysqli_fetch_assoc($result_products)) {
                $number ++;
                echo "<tr>";
                echo "<td>" . $fetch_row['category_id'] . "</td>";
                echo "<td>" . $fetch_row['category_name'] . "</td>";
                echo "<td>" . $fetch_row['category_description'] . "</td>";
                echo "<td><a href='admin.php?edit_category=$fetch_row[category_id]' ><svg xmlns='http://www.w3.org/2000/svg' height='24' width='24' viewBox='0 0 512 512'><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg></a></td>";
                echo "<td><a href='admin.php?delete_category=$fetch_row[category_id]' onclick='openModal(event)'><svg xmlns='http://www.w3.org/2000/svg' height='24' width='21' viewBox='0 0 448 512'><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg></a></td>";
                echo "</tr>"; //class='open-modal-button' we are not using this class in the modal because it interferes with our previous styling for the svg
            }
                ?>
        </tbody>

<!-- The Modal -->
<div class="modal" id="myModal">
    <span class="close-modal-button" onclick="closeModal()">&times;</span>
    <p>Are you sure you want to delete?</p>
    <div class="modal-buttons">
    <button class="yes" onclick="handleYes()">Yes</button>
    <button class="no" onclick="handleNo()">No</button>
    </div>
</div>

<!-- The Overlay -->
<div class="overlay" id="overlay" onclick="closeModal()"></div>
    </table>
</body>
</html>

<script>
        // JavaScript functions to open and close the modal
        function openModal(event) {
            event.preventDefault(); // Prevent the default action (navigation)
            console.log('Open modal called');
            document.getElementById('myModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        // Functions to handle Yes and No actions
        function handleYes() {
          //  alert('You clicked Yes!');
            closeModal();
        }

        function handleNo() {
           // alert('You clicked No!');
            window.location.href = './admin.php'; // Redirect to admin.php
        }
    </script>