<?php
if(isset($_GET['edit_goods'])){
    $edit_id = $_GET['edit_goods']; //get variable used to retrieve specific product id
    $get_data = "SELECT * FROM `products` where product_id=$edit_id";
    $execute_data = mysqli_query($con,$get_data);
    $get_row = mysqli_fetch_assoc($execute_data);
    $product_name=$get_row['product_name'];
    $product_description=$get_row['product_description'];
    $category_id=$get_row['category_id'];
    $product_keywords=$get_row['product_keywords'];
    $product_price=$get_row['product_price'];
    $product_image=$get_row['product_image'];

    //fetching category name
    $select_category="SELECT * FROM `category` where category_id=$category_id";
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
    <title>Edit Product</title>
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
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>
    <form action="" method="post" enctype="multipart/form-data" >
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" value="<?php echo $product_name ?>" name="productName" required>

        <label for="productDescription">Product Description:</label>
        <textarea id="productDescription" name="productDescription" rows="4" required><?php echo $product_description ?></textarea>

        <label for="productKeywords">Product Keywords:</label>
        <input type="text" id="productKeywords" value="<?php echo $product_keywords ?>" name="productKeywords" required>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="<?php echo $category_name ?>"><?php echo $category_name ?></option>
            <?php
            $select_all_category = "SELECT * FROM `category`";
            $execute_category = mysqli_query($con,$select_all_category);
            while($row_all_category = mysqli_fetch_assoc($execute_category)){
                $category_name = $row_all_category['category_name'];
                $category_id = $row_all_category['category_id'];
                echo "<option value='$category_id'>$category_name</option>";
            }
            ?>
        </select>

        <label for="categoryDescription">Category Description:</label>
        <textarea id="categoryDescription" name="categoryDescription" rows="4" required><?php echo $category_description ?></textarea>

        <label for="productPrice">Product Price:</label>
        <input type="number" id="productPrice" value="<?php echo $product_price ?>" name="productPrice" required>

        <label for="productImage">Product Image </label>
        <div class="file-container">
        <input type="file" id="productImage" name="productImage" required>
        <img src="./product_images/<?php echo $product_image ?>" alt="product image">
        </div>

        <button type="submit" name="update_product">Update Product</button>
    </form>
</div>
</body>
</html>
<!--editing products in the db -->
<?php
if(isset($_POST['update_product'])){
    $edit_product_name = $_POST['productName'];
    $edit_product_description = $_POST['productDescription'];
    $edit_product_keywords = $_POST['productKeywords'];
   // $edit_category_name = $_POST['category'];
    $edit_category_id =$_POST['category'];
    $edit_category_description = $_POST['categoryDescription'];
    $edit_product_price = $_POST['productPrice'];

    //actually image removes from form
    $edit_product_image = $_FILES['productImage']['name'];
    //temporary storage
    $tmp_product_image = $_FILES['productImage']['tmp_name'];

    
    if(empty($edit_product_name) || empty($edit_product_description) || empty($edit_product_keywords) || empty($edit_category_id) || empty($edit_category_description) || empty($edit_product_price) || empty($edit_product_image)){

        echo"<script>alert('Please fill out the missing fields')</script>";
    }
    else{
        move_uploaded_file($tmp_product_image,"./product_images/$edit_product_image");
        //query to update products table
        $update_all_products = "UPDATE `products` SET product_name='$edit_product_name',product_description='$edit_product_description',category_id=$edit_category_id,product_keywords='$edit_product_keywords',product_price='$edit_product_price',product_image='$edit_product_image',date=NOW() where product_id=$edit_id";
        $result_update_product = mysqli_query($con,$update_all_products);

        // query to update category table
        $update_category = "UPDATE `category` SET category_description='$edit_category_description' WHERE category_id=$edit_category_id";
        $result_update_category = mysqli_query($con, $update_category);

        if($result_update_product && $result_update_category){
            echo "<script>alert('Product updated successfully')</script>";
            echo "<script>window.open('./admin.php?view_goods','_self')</script>";
        }
        else{
            echo "<script>alert('Product not updated ')</script>";

        }
    }
}

?>
