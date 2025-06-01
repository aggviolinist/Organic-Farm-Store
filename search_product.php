<?php
session_start();
if (isset($_GET['logout2'])) {
    session_destroy();
    echo "<script>window.open('index.php','_self')</script>";
    exit();
}
include('includes/connect.php');
include('functions/common_functions.php');

global $con;
$search_query = "select * from products";
$result_query = mysqli_query($con,$search_query);

while($show_goods=mysqli_fetch_assoc($result_query)){
    $product_id = $show_goods['product_id'];
    $product_name = $show_goods['product_name'];
    $product_description = $show_goods['product_description'];
    $product_category = $show_goods['category_id'];
    $product_keywords = $show_goods['product_keywords'];
    $product_price = $show_goods['product_price'];
    $product_image = $show_goods['product_image'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="products.css">
</head>
<body>
    <header>
        <h1>Our Products</h1>
    </header>
    <nav>
    <div style=" float: left; margin-left: 20px; line-height: 50px;" class="user-section">
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            $switch_username = $_SESSION['username'];
            echo "<p style='color:#000000; font-size: 25px;'>Hi, $switch_username!</p>";
        } else {
            // If not logged in, display the login button
            echo "<svg xmlns='viewBox='0 0 16 16' width='16' height='16'><path d='M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16Zm.847-8.145a2.502 2.502 0 1 0-1.694 0C5.471 8.261 4 9.775 4 11c0 .395.145.995 1 .995h6c.855 0 1-.6 1-.995 0-1.224-1.47-2.74-3.153-3.145Z'></path></svg>
            <a style='text-decoration: none; color: #49beb7; font-size: 25px;' href='user_panel/user_login.php'>Sign in</a>";
      
        }
        ?>
    </div>
        <ul>
            <li><a style="text-decoration:none" href="#vegetables">Vegetables</a></li>
            <li><a style="text-decoration:none" href="#fruits">Fruits</a></li>
            <li><a style="text-decoration:none" href="#poultry">Chicken & Eggs</a></li>
            <li><a style="text-decoration:none" href="#honey">Honey</a></li>
            <li><a style="text-decoration:none" href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg><sup style="font-size:22px;color: black;";><?php no_items_in_cart() ?></sup></a></li>
            <li><a style="text-decoration:none" href="user_panel/profile.php">My Account</a></li>
        </ul>
        <div class="search-bar">
            <form method="get" action=" ">
            <input type="text" placeholder="Search" name="search_products">
            <button type="submit" value="search" name="search_btn">search</button>
            </form>          
        </div>
        <div class="search-bar" style='margin-bottom:50px;'>
        <a href="?logout2=1"><button style='color:#000000; float: left; cursor: pointer;' type="submit" value="logout2" name="logout2">Log out</button></a>    
        </div>
    </nav>
    <main>
    <?php
            search_product();
            cart();
            ?>
    </main>
    <script src="products.js"></script>
</body>
</html>

<!-- <script>
    const productList = document.getElementById("product-veggies");
    const products = Array.from(productList.children);

    products.sort(() => Math.random() - 0.5); // Randomize order

    products.forEach((product) => productList.appendChild(product));
</script> -->