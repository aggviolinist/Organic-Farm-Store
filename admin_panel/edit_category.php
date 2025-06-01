<?php
if(isset($_GET['edit_category'])){
    $edit_category = $_GET['edit_category']; //get variable used to retrieve specific category id

    //fetching category name
    $select_category="SELECT * FROM `category` where category_id=$edit_category";
    $execute_select_category = mysqli_query($con,$select_category);
    $row_category = mysqli_fetch_assoc($execute_select_category);
    $category_name = $row_category['category_name'];
    $category_description = $row_category['category_description'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>

<div class="container">
    <h2>Edit Category</h2>
    <form action="" method="post" >
        <label for="categoryName">Category Name:</label>
        <input type="text" value="<?php echo $category_name ?>" id="categoryName" name="categoryName" required>

        <label for="categoryDescription">Category Description:</label>
        <textarea id="categoryDescription" name="categoryDescription" rows="4" required><?php echo $category_description ?></textarea>

        <button type="submit" name="update_category">Update Category</button>
        
    </form>
    
</div>

</body>
</html>
<!--editing products in the db -->
<?php
if(isset($_POST['update_category'])){
    $edit_category_name = $_POST['categoryName'];
    $edit_category_description = $_POST['categoryDescription'];

    
    if(empty($edit_category_name) || empty($edit_category_description) ){

        echo"<script>alert('Please fill out the missing fields')</script>";
    }
    else{
        // query to update category table
        $update_category = "UPDATE `category` SET category_name='$edit_category_name',category_description='$edit_category_description' WHERE category_id=$edit_category";
        $result_update_category = mysqli_query($con, $update_category);

        if($result_update_category){
            echo "<script>alert('Product updated successfully')</script>";
            echo "<script>window.open('./admin.php?view_cat','_self')</script>";
        }
        else{
            echo "<script>alert('Product not updated ')</script>";

        }
    }
}

?>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;            
        }

        button:hover {
            background-color: #45a049;
        }
        input[type="file"] {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        img {
            width: 100px; 
            margin-left: 10px; 
        }
        .file-container {
            display: flex;
            align-items: center;
            
        }
    </style>

