<?php include('partials-front/menu.php') ?>

<?php 
        //CHeck whether food id is set or not
        if(isset($_GET['food_id']))
        {
            //Get the Food id and details of the selected food
            $food_id = $_GET['food_id'];

            //Get the DEtails of the SElected Food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            //Execute the Query
            $res = mysqli_query($conn, $sql);
            //Count the rows
            $count = mysqli_num_rows($res);
            //CHeck whether the data is available or not
            if($count==1)
            {
                //WE Have DAta
                //GEt the Data from Database
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                //Food not Availabe
                //REdirect to Home Page
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirect to homepage
            header('location:'.SITEURL);
        }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">

                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                                // Check whether the image is available or not
                                if($image_name=="")
                                {
                                    // Display Message
                                    echo '<div class="error">Image is not available</div>';
                                }
                                else
                                {
                                    // Image available
                                    ?>
                                        <img src="<?php echo SITEURL ?>images/food/<?php echo $image_name?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
    
    // Check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // Get all the details from the form
        //$oder_id=$_POST['id'];
        $oder_food=$_POST['food'];
        $oder_qty=$_POST['qty'];
        $oder_price=$_POST['price'];
        $oder_total=$price * $oder_qty;
        
        $oder_order_date=date("Y-m-d h:i:sa");
        $oder_status="ordered";  // Ordered, on delivery, Delivered
        $oder_customer_name=$_POST['full-name'];
        $oder_customer_contact=$_POST['contact'];
        $oder_customer_email=$_POST['email'];
        $oder_customer_address=$_POST['address'];

        // Save the order in database 
        // Create sql to save the data
        $sql2="INSERT INTO tbl_order SET
            food='$oder_food',
            price=$price,
            qty=$oder_qty,
            total=$oder_total,
            order_date='$oder_order_date',
            status='$oder_status',
            customer_name='$oder_customer_name',
            customer_contact='$oder_customer_contact',
            customer_email='$oder_customer_email',
            customer_address='$oder_customer_address'        
        ";

        // Execute the query
        $res2=mysqli_query($conn,$sql2);

        if($res2==true)
        {
            // Query executed and order saved
            $_SESSION["order_placed"]="<div class='success text-center'>Food ordered successfully </div>";
            header('location:'.SITEURL);
        }
        else
        {
            // Failed to save order
            $_SESSION["order_not_placed"]="<div class='error text-center'>Food not ordered </div>";
            header('location:'.SITEURL);
            // echo "order not saved";
        }



    }
    
    ?>

    <?php include('partials-front/footer.php') ?>