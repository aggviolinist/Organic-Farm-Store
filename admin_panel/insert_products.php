<?php
include('../includes/connect.php'); //includes the connect.php page, the 2 dots show the level we go to get to the includes folder

if(isset($_POST['add_products'])){//if add products button is clicked then do the following

    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_category = $_POST['product_category'];
    $product_keywords = $_POST['product_keyword'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';
    //Accessing image name as files now
    $product_image = $_FILES['product_image']['name'];   
    //Accessing image temporarily as files now
    $product_tmp_image = $_FILES['product_image']['tmp_name'];
    $folder = "./product_images/" . $product_image;
   // move_uploaded_file($gas_image_tmp,"Admin/gas_images/$gas_image");

    //== checking condition, = assigning
    //Checking for empty fields
    if(empty($product_name) || empty($product_description) || empty($product_category) || empty($product_keywords) || empty($product_price) || empty($product_image)){

        echo"<script>alert('Please fill out the missing fields')</script>";
    }
    else{
        //moving the image from images to admin_panel 
      //  $destination = "C:/xampp/htdocs/FarmStore/admin_panel/product_images/" . $product_image;
        move_uploaded_file($product_tmp_image,$folder);
        // //Only allow JPG, JPEG, PNG

        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
        // echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        // $uploadOk = 0;
        // }
        //insert query
        $insert_products = "INSERT INTO `products` (product_name, product_description, category_id, product_keywords, product_price, product_image, date, status) VALUES ('$product_name', '$product_description', '$product_category', '$product_keywords', '$product_price', '$product_image', NOW(), '$product_status')";
      //  $sql = "INSERT INTO products (product_image) VALUES ('$product_image')";
      //mysqli_query($con, $sql);
        //executing query
        $execute_query = mysqli_query($con,$insert_products);
        if($execute_query){
            echo "<script>alert('Successfully inserted the products')</script>";
        }else {
            echo "<script>alert('Failed to insert the product')</script>";
        }
        }      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products</title>
    <link rel="stylesheet" href="insert_products.css">
</head>
<body>
    <h1 class="heading">Insert Farm Products</h1>
    <form action = " " enctype="multipart/form-data" method="post" id="product-form" > <!-- The action is blank coz PHP code falls on the same page as the form -->
        <div class="form-group">  <!-- enctype allows the input of data that is not only textual, images too-->
            <label for="product_name">Farm Product Name:</label>
            <input type="text" id="product_name" name="product_name" placeholder="Enter product name" autocomplete="off" required>
        </div>  <!-- label for and ID should match coz of the DB--> 
        <div class="form-group">
            <label for="product_description">Farm Product Description:</label>
            <textarea id="product_description" name="product_description" placeholder="Enter product description" autocomplete="off" required></textarea>
        </div>

        <div class="form-group">
                <label for="product_category">Select Category:</label>
                <select id="product_category" name="product_category">
                    <option value="selection">Select Category</option>
                    <?php
                    $select_query = "select * from `category`";
                    $result_query = mysqli_query($con,$select_query);
                    while($row=mysqli_fetch_assoc($result_query)){
                        $category_name = $row['category_name'];
                        $category_id = $row['category_id'];
                        echo "<option value='$category_id'>$category_name</option>";
                    }
                     ?>
                </select>
            </div>    
        <div class="form-group">
            <label for="product_keyword">Farm Product Keyword:</label>
            <input type="text" id="product_keyword" name="product_keyword" placeholder="Enter product keyword" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label for="product_price">Farm Product Price:</label>
            <input type="number" id="product_price" name="product_price" step="1" placeholder="Enter product price" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label for="product_image">Farm Product Image:</label>
            <input type="file" id="product_image" name="product_image">
        </div>
        <button type="submit" name="add_products" value="add products">Add Farm Product</button>
        <div>
    </form>        
</body>
</html>
