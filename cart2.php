<DOCTYPE html>
 <?php

?>
    <head>
    <title>BOOK A CYLINDER</title>
    <link rel="stylesheet" href="css/style.css" media="all"> <!--Linking relationship stylesheet with hypertext reference on all kind of devices -->
    <link rel="stylesheet" type="text/css"href="css font_awesome/all.min.css"><!--font awesome link-->

</head>
<body>
<div class= "main_wrapper"> <!--css class-->
    <div class = "header_wrapper"> <!--header div -->
    <img id= "lpg" src = "images/dial.png" />  <!--image source-->
    <img style='margin-left: 250px;'id= "logo"src = "images/run.jpg"/>
    </div>
</div>
<div class="menubar"> <!--menu div -->
<ul id="menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="allgases.php">Book Cylinder</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="login.php">Log in</a></li>
    <li><a href="signup.php">Sign up</a></li>
</ul>
<div id="form">
    <form method="get" action="search_gas.php" enctype="mutlipart/form-data"><!--Multitype  used when getting images from DB-->
    <input style= 'margin-left:220px;' type="text" name="user_text" placeholder="what are you looking for?"/>
    <input type="submit" name="search" value="find gas cylinder" />
    </form> 
</div>
</div> 

     <div class="content_wrapper">
     <?php
        //total_in_the_cart();
    ?>
        <div style="width: 800px; height: 40px;background-color: lawngreen; padding-left: 700px; margin:right:100px; margin-left:250px;"><!--shopping cart -->
          <span style="float:left; text-align: center; font-size: 18px; padding:5px; line-height:40px">
          Welcome User!
          </span>
          <i style='padding:18px;'class="fa-solid fa-cart-shopping"></i><a style='text-decoration:none;color:blue' href="mycart.php">Your Cart has <?php
       // total_gas_in_the_cart();?>gases </a> 
        <span>Please pay: <?php // total_sum_in_cart(); ?> Shillings</span>


        </div>

        <div id="sidebar">  <!--side div -->
        <div>
            <ul id="siddy">
            <li><i class="fa-solid fa-house-user"></i><a href="index.php">Dashboard</a></li><br>
            <li><i class="fa-solid fa-cart-shopping"></i><a href="cart.php">Cart</a></li><br>
            <li><i class="fa-solid fa-calendar-check"></i><a href="allgases.php">Book cylinder</a><li padding-right:10px;><?php // getWeight(); ?></li></li><br> 
            <li><i class="fa-solid fa-user"></i><a href="customer_account.php">My account</a></li><br>
            <li><i class="fa-solid fa-power-off"></i><a href="#">Log out</a></li>
       
        </ul>        
        </div>
        </div>
        <div id= "content_area" ><!--content area div -->
        <form action="" method="post" enctype="multipart/form-data">
            <table align="center" width="1600" bgcolor="#ADD8E6">
            <tr align="right">                
                <th><i class="fa-solid fa-trash" style=padding:10px></i>Remove from cart</th> <!--th is a table heading -->
                <th><i class="fa-solid fa-fire-flame-simple" ></i>Gas cylinder(s)</th>
                <th><i class="fa-solid fa-hashtag"></i>Quantity</th>
                <th><i class="fa-solid fa-dollar-sign"></i>Total price</th>
            </tr>
            
            <tr align="right">
                <td><input type="checkbox" name="kill[]" value="<?php echo $display_cylinderID; ?>"></td> <!--delete is of an array and it passes all records to the below for each loop since they have unique ID's-->
                <td><?php echo $get_gas_name; ?><br><img src = "images/<?php echo $get_gas_image;?>" width="100" height="100"/>
            </td>
            <td><input type="button" size="3" onclick="decrementValue()" value="-"/>
                <input type="text" name="quantity" value="1" maxlength="2" max ="10" size= "1" id="number" value='<?php echo $_SESSION["quantity"];?>' />
                <input type="button" onclick="incrementValue()" value="+"/>
            </td>
                        
            <td><?php $currency = " shillings"; //variable
            echo $get_individual_gas_cylinder_price . $currency;?></td>
            
            </tr>
            <?php            
        ?>
         <script type="text/javascript">

                    function incrementValue()
                    {
                        var value = parseInt(document.getElementById('number').value,10);
                        value = isNaN(value) ? 0 : value;//NaN function checks if the value is not a number
                        if(value<10)
                        {
                            value ++;
                            document.getElementById('number').value = value;
                        }
                    }
                    function decrementValue()
                    {
                        var value = parseInt(document.getElementById('number').value, 10);// returns an Element object representing the element whose id property matches the specified string.
                        value = isNaN(value) ? 0 : value;

                        if(value>1)
                        {
                            value --;
                            document.getElementById('number').value = value;
                        }
                    }

        </script>
        <!--table for total price colspan is for spacing -->
           <tr align="right">
                <td colspan="3"><b>Total:</b></td>
                <td><b><?php
                $currency = " shillings";
                echo $total .$currency;
                ?></b></td>
            </tr>
            <!-- table for updating the cart -->
            <tr align ="center">
                <td colspan="2"><br><br><br><br><br><br><i class="fa-solid fa-trash-can"></i><input type="submit" name="remove" value="Remove"></td> <!--table row -->
                <td><br><br><br><br><br><br><input type="submit" name="update_quantity" value="update quantity"></td>
                <td style='margin-left:10px'><br><br><br><br><br><br><i class="fa-sharp fa-solid fa-rotate-left"></i><input type="submit" name="back_shopping" value="Back to Shopping"></td>
                <td><br><br><br><br><br><br><a href="checkout.php" style='text-decoration:none;color:black'><i class="fa-solid fa-cart-shopping"></i></a><button><a href="checkout.php" style='text-decoration:none; color:black';>Check Out</a></button></td>                              
            </tr>
            </table>
        </form> 
        <?php
            //update quantity function                             
            if(isset($_POST['update_quantity']))
            {
                $quantity = $_POST['quantity']; 
                $update_quantity = "update cart set quantity='$quantity'"; //setting the quantity to be whats in the field 
                $run_update_quantity = mysqli_query($connection,$update_quantity);

                //we use sessions here to keep or hold the value in the quantity box 
                $_SESSION['quantity']=$quantity;//default super global array just like POST,GET,FILE,REQUEST

                $total = $total*$quantity;//in PHP we can change local variables at any time.Total is the same no need to define it in this php function

            }            
            ?> 
        <?php
         //function cart_delete_update() had to comment this function coz it wasn't removing any item from cart
         //{
        global $connection;
//$ip = getIP();
        if(isset($_POST['remove']))//if the button with name "remove" is clicked in line 173, make a post 
        {
            foreach($_POST['kill'] as $kill_id)//loop that targets array kill[] which has the gas id and passes it as a local variable kill_id
            {
                $delete_gas = "delete from cart where cylinder_id='$kill_id' AND ip_address='$ip'";
                $run_delete_gas = mysqli_query($connection,$delete_gas);
                 
                if($run_delete_gas)
                {
                    echo "<script>window.open('mycart.php','_self')</script>";
                    echo '<script>alert("Gas Cylinder deleted successfully ")</script>';

                }
                else
                {
                    echo '<script>alert("Gas Cylinder not deleted successfully ")</script>';

                }
               
            }
        }
            if(isset($_POST['back_shopping']))
            {
                echo '<script>window.open("index.php","_self")</script>';
               
            }
            //echo @$cart_update= cart_delete_update(); //if the function is not  active don't generate an error coz we are doing 2 tasks at the same time
 
        //}         
        ?>
        
        <div id="display"> <!--calling the display function --->
        <?php 
        //echo $ip = getIP()
        ?>

            <?php
            //display_index();
            ?>
            <?php // categorize_weight();?>
         </div>
        </div> 

      </div>
         <div id ="footer" style=padding-top:30px;>Kelvin Mulandi &copy; All Rights Reserved</div> <!--footer div -->

</body>
</html>
