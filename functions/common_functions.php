<?php
include("./includes/connect.php");
global $con;
//searching products
function search_product(){
    global $con;
    $currency = "shillings per piece";
    if(isset($_GET['search_btn'])){
    $search_product = $_GET['search_products'];
    $search_query = "select * from `products` where product_keywords like '%$search_product%'";
    $result_query = mysqli_query($con,$search_query);
    $num_of_rows = mysqli_num_rows($result_query);
    if($num_of_rows==0){
        echo "<h2 style='font: size 100px;'>This product is not available</h2>";
    }

    while($show_goods=mysqli_fetch_assoc($result_query)){
        $product_id = $show_goods['product_id'];
        $product_name = $show_goods['product_name'];
        $product_description = $show_goods['product_description'];
        $product_category = $show_goods['category_id'];
        $product_keywords = $show_goods['product_keywords'];
        $product_price = $show_goods['product_price'];
        $product_image = $show_goods['product_image'];

    
        echo "<div class='product'>
            <h3>$product_name</h3>
            <img src='admin_panel/product_images/$product_image' alt='$product_name' style='border: 3px solid #white; margin: 30px;' width='100' height='250'>
            <p>$product_description</p>
            <h4>Price: $product_price $currency </h4>
          <a href='products.php?add_to_cart=$product_id'><button class='cartadd'>Add to Cart</button></a>
        </div>";
        
    }
    }
}

//getting ip address
function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;  

function cart(){
    if(isset($_GET['add_to_cart'])){ //this get variable we are getting when clicked
        global $con; //variable is on another page
        $get_ip_addy = getIPAddress();
        $get_product_id = $_GET['add_to_cart'];
        $select_query = "Select * from `cart` where ip_address='$get_ip_addy' and product_id=$get_product_id";
        $result_query = mysqli_query($con,$select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if($num_of_rows>0){
            echo "<script>alert('Product is already present inside your cart')</script>";
            echo "<script>window.open('products.php','_self')</script>";
        }
        else{
            $insert_query = "insert into cart(product_id,ip_address,quantity) values($get_product_id,'$get_ip_addy',0)";
            $result_query = mysqli_query($con,$insert_query);
            echo "<script>alert('Product successfully added to your cart')</script>";
            echo "<script>window.open('products.php','_self')</script>";
        }
    }
}
//calculating no of items in cart
function no_items_in_cart(){
    if(isset($_GET['add_to_cart'])){ //this get variable we are getting when clicked
        global $con; //variable is on another page
        $get_ip_addy = getIPAddress();
        $select_query = "Select * from `cart` where ip_address='$get_ip_addy'";
        $result_query = mysqli_query($con,$select_query);
        $count_cart_items = mysqli_num_rows($result_query);
       }
        else{
            global $con;
            $get_ip_addy = getIPAddress();
            $select_query = "Select * from `cart` where ip_address='$get_ip_addy'";
            $result_query = mysqli_query($con,$select_query);
            $count_cart_items = mysqli_num_rows($result_query);
        }
        echo $count_cart_items;
        
    }
//getting the total price in cart
function cart_total(){
    global $con; //variable is on another page so global makes it accesssible
    $total = 0;
    $get_ip_addy = getIPAddress();
    $count_cart = "select * from `cart` where ip_address='$get_ip_addy'";
    $execute_count_cart = mysqli_query($con,$count_cart); 
    while($cart_rows = mysqli_fetch_array($execute_count_cart)){
        $product_id = $cart_rows['product_id'];
        $select_product_query = "select * from `products` where product_id='$product_id'";
        $execute_product_query = mysqli_query($con,$select_product_query);
        while($cart_products_price = mysqli_fetch_array($execute_product_query)){
            $product_price = array($cart_products_price['product_price']);
            $total_product_price = array_sum($product_price);
            $total += $total_product_price;
        }
    }
    echo $total;
}
?>

<!--Styling the search product function and page-->
<style>
   .product {
    border: 0px white;
    border-radius: 0px;
    box-shadow: 0 0px 0px 0 rgba(0, 0, 0, 0);
    margin: 20px;
    padding: 20px;
    display: inline-block;
    width: 300px;
    text-align: center;
    background-color: #fff;
    transition: transform 0.3s;
}

.product:hover {
    transform: scale(1.05);
}
.product h3 {
    font-size: 24px;
    margin: 10px 0;
}

.image-container {
    border: 3px solid #FFE5B4;
    margin: 30px;
    overflow: hidden;
}

.product img {
    width: 100%;
    height: 160px;
    max-width: 100%;
    object-fit: contain;
}

.product p {
    font-size: 16px;
    margin: 10px 0;
}

.product h4 {
    font-size: 20px;
    margin: 10px 0;
}

.cartadd {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    border-radius: 15px;
}

.cartadd:hover {
    background-color: #0056b3;
}
</style>