<?php
include('../includes/connect.php'); //includes the connect.php page, the 2 dots show the level we go to get to the includes folder

if(isset($_POST['add_category'])){ //We take data from button
    $cat_name=$_POST['category_name']; //POST method gets what is inside the text area
    $cat_desc = $_POST['category_desc'];

    //Selecting data from our table
    $select_query = "Select * from `category` where category_name='$cat_name'";
    //Executing the select command
    $result_of_select = mysqli_query($con,$select_query);
    //counting the number of rows in the table
    $number_pf_rows_present =  mysqli_num_rows($result_of_select);
    //if the rows are more than 0 give an error meaning category is already present
    if($number_pf_rows_present>0){
        echo "<script>alert('This category is present inside the database')</script>";
    }
    //if not add a new entry the database
    else{
    //insert query
    $insert_query="insert into `category` (category_name,category_description) values ('$cat_name','$cat_desc')";
    //Executing query
    $result=mysqli_query($con,$insert_query);
    //Positive feedback
    if($result){
        echo "<script>alert('Category has been inserted successfully')</script>";
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="insert_category.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Insert Category</h1>
        <form action=" " method="post" id="category-form">
            <div class="form-group">
                <label for="category_name">Product Category:</label>
                <input type="text" id="category_name" name="category_name" class="custom-input"required>
                <br>
                <label for="category_desc">Product Description:</label>
                <textarea id="category_desc" name="category_desc" rows="4" class="custom-input" required></textarea>

            </div>
            <button name="add_category" value="add category" type="submit">Add Category</button>
        </form>
    </div>
</body>
</html>
<style>
    .custom-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 30px; /* Add margin-bottom for spacing between input fields */
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>