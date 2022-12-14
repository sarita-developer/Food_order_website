<?php include('partials-front/menu.php') ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            
                // Create SQL query to display categories From database
                $diplay_cat_query="SELECT * FROM tbl_category WHERE active='yes'AND featured='yes'";

                // Execute the query
                $res=mysqli_query($conn,$diplay_cat_query);

                // Count rows to check whether the category is available or not
                $count=mysqli_num_rows($res);

                if($count>0)
                {
                    // Category is vailable
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // Get the values like id, title, image_name
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];

                        ?>
                                            
                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id ?>">
                            <div class="box-3 float-container">
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
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Category Image" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                <h2 class="float-text text-white"><?php echo $title;  ?></h2>
                            </div>
                            </a>

                        <?php

                    }
                }
                else
                {
                    // Categories not available
                    echo '<div class="error">Category not added.</div>';
                }

            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php') ?>
