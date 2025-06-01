<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Account</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .delete-container {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 1280px;
      text-align: center;
    }

    h2 {
      color: #ff0000; 
    }

    p {
      margin-bottom: 20px;
    }

    button {
      background-color: #ff0000;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
    <form action="" method="post">
  <div class="delete-container">
    <h2>Confirm Deletion</h2>
    <p>Are you sure you want to delete your account?</p>   
    <button type="submit" name="delete">Delete</button>
  </div>
    </form>
</body>
</html>
<?php
    $username_session = $_SESSION['username'];
    if(isset($_POST['delete'])){
        $delete_query = "delete from `users` where username='$username_session'";
        $execute_delete_query = mysqli_query($con,$delete_query);
        if($execute_delete_query){
            session_destroy();
            echo "<script>alert('We are so sad to see you go $username_session :(')</script>";
            echo "<script>window.open('../index.php','_self')</script>";
        }
    }


?>

