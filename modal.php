<?php
include('includes/connect.php');
include('functions/common_functions.php');

global $con;
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

        <button class="open-modal-button" onclick="openModal()">Open Modal</button>


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
           // event.preventDefault(); // Prevent the default action (navigation)
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
            window.location.href = '/index.php'; // Redirect to admin.php
        }
    </script>