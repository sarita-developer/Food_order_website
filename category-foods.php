<?php include('partials-front/menu.php') ?>

<?php

    // Check whether id is passed or not
    if(isset($_GET['category_id']))
    {
        // Category id is set
        $category_id=$_GET['category_id'];

        // Get  the category title based on id
        $select_title_query="SELECT title FROM tbl_category WHERE id=$category_id";

        // Execute the query
        $res=mysqli_query($conn,$select_title_query);

        // Get the value from database
        $row=mysqli_fetch_assoc($res);

        // Get the title
        $category_title=$row['title'];
    }
    else
    {
        // Category not passed
        // Redirect to home pae
        header('location:'.SITEURL);
    }

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
            
            // Create sql qury to get food based on selected category
            $select_food_query="SELECT * FROM tbl_food WHERE category_id=$category_id";

            // Execute the query
            $res2=mysqli_query($conn,$select_food_query);

            // Count the rows
            $count_food_rows=mysqli_num_rows($res2);

            // Check whether the food is available or not
            if($count_food_rows>0)
            {
                // Food is available
                while($row2=mysqli_fetch_assoc($res2))
                {
                    $food_id=$row2['id'];
                    $food_title=$row2['title'];
                    $food_price=$row2['price'];
                    $food_description=$row2['description'];
                    $food_image_name=$row2['image_name'];

                    ?>
                    
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    // Check whether image name is available or not
                                    if($food_image_name=="")
                                    {
                                        //Image not Available
                                        echo "<div class='error'>Image not Available.</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php 

                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $food_title ?></h4>
                                <p class="food-price">$<?php echo $food_price ?></p>
                                <p class="food-detail">
                                    <?php echo $food_description ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL ?>order.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                    
                    <?php

                }
            }
            else
            {
                // Food not available
                echo "<div class='error'>Food is not available</div>";
            }
            

            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>

    <?php include('partials-front/footer.php') ?>
