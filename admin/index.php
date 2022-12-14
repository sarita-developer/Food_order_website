
<?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Dashboard</h1>
                <br><br>
                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>
                <br><br>

                <div class="col-4 text-center">
                    <!-- Display number of categories -->
                    <?php 
                    
                    // SQL query
                    $category_query="SELECT * FROM tbl_category";
                    
                    // Execute query
                    $res=mysqli_query($conn,$category_query);

                    // Count rows
                    $count_category=mysqli_num_rows($res);                    
                    
                    ?>
                    <h1><?php echo $count_category; ?></h1>
                    <br />
                    Categories
                </div>

                <div class="col-4 text-center">

                    <!-- Display number of food -->
                    <?php 
                    
                    // SQL query
                    $food_query="SELECT * FROM tbl_food";
                    
                    // Execute query
                    $res=mysqli_query($conn,$food_query);

                    // Count rows
                    $count_food=mysqli_num_rows($res);     
                    ?>               
                    
                    <h1><?php echo $count_food; ?></h1>
                    <br />
                    Foods
                </div>

                <div class="col-4 text-center">
                    
                    <!-- Display number of orders -->
                    <?php 
                    
                    // SQL query
                    $order_query="SELECT * FROM tbl_order";
                    
                    // Execute query
                    $res=mysqli_query($conn,$order_query);

                    // Count rows
                    $count_order=mysqli_num_rows($res);     
                    ?> 

                    <h1><?php echo $count_order; ?></h1>
                    <br />
                    Total Orders
                </div>

                <div class="col-4 text-center">
                    <!-- Display revenue generated till now -->
                
                    <?php
                    
                    // Create SQL query to get total revenue generated
                    // Aggregate Function in SQL

                    $sum_price="SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                    // Execute the query
                    $res2=mysqli_query($conn,$sum_price);

                    // Get the value
                    $row=mysqli_fetch_assoc($res2);

                    // Get the total revenue
                    $total_revenue=$row['Total'];
                    
                    ?>

                    <h1>$<?php echo $total_revenue; ?></h1>
                    <br />
                    Revenue Generated
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main Content Setion Ends -->

<?php include('partials/footer.php') ?>