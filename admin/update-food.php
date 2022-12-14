<?php include('partials/menu.php'); ?>

<?php

// check whether id is set or not
if(isset($_GET['id']))
{
    // Get all the details
    $id=$_GET['id'];

    // $sql query to get the selected food
    $select_food_query="SELECT * FROM tbl_food WHERE id=$id";

    // execute the query
    $res2=mysqli_query($conn,$select_food_query);

    // Get the values based on the query executed
    $row2=mysqli_fetch_assoc($res2);

    // Get the individual values of selected food
    $title=$row2['title'];
    $description=$row2['description'];
    $price=$row2['price'];
    $current_image=$row2['image_name'];
    $current_category=$row2['category_id'];
    $featured=$row2['featured'];
    $active=$row2['active'];


}
else
{
    // Redirect to Manage Food
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">


                <tr>
                    <td>Title</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                
                <tr>
                    <td>Description</td>
                    <td><textarea name="description" cols="14" rows="2" ><?php echo $description; ?></textarea></td>
                </tr>
                
                <tr>
                    <td>Price</td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>
                
                <tr>
                    <td>Current Image</td>
                    <td>
                    <?php 
                            if($current_image != "")
                            {
                                //Display the Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Display Message
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select Image</td>
                    <td><input type="file" name="image" ></td>
                </tr>
                
                
                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category">


                        <?php                                                                               
                                // Create php code to display categories from database
                                // Create  SQL  to get all active categories from database
                                $select_cat_query="SELECT * FROM tbl_category WHERE active='Yes'";
                                
                                $res=mysqli_query($conn,$select_cat_query);

                                // Count rows to check whether we have categories or not
                                $count=mysqli_num_rows($res);


                                // If count is greater than zero, we have categories else we don't have categories
                                if($count>0)
                                {
                                    // We have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        // Get the details of categories
                                        $category_id=$row['id'];
                                        $category_title=$row['title'];

                                        ?>

                                            <option <?php if($current_category==$category_id){ echo "selected"; } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    // We don't have categories
                                    ?>
                                        <option value="0">No category found</option>
                                    
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                
                
                <tr>
                    <td>Featured</td>
                    <td>
                        <input <?php if($featured=="yes"){echo "checked";} ?> type="radio" name="featured" value="yes"> Yes 

                        <input <?php if($featured=="no"){echo "checked";} ?> type="radio" name="featured" value="no"> No 
                    </td>
                </tr>
                
                
                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if($active=="yes"){echo "checked";} ?> type="radio" name="active" value="yes"> Yes 

                        <input <?php if($active=="no"){echo "checked";} ?> type="radio" name="active" value="no"> No 
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php


            if(isset($_POST['submit']))
            {
                // Get the etails from the form 
                $new_food_id=$_POST['id'];
                $new_food_title=$_POST['title'];
                $new_food_description=$_POST['description'];
                $new_food_price=$_POST['price'];
                $new_food_current_image=$_POST['current_image'];
                $new_food_category=$_POST['category'];
                $new_food_featured=$_POST['featured'];
                $new_food_active=$_POST['active'];          

                // Upload the image if selected 

                // check upload image button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    // Button clicked
                    $image_name=$_FILES['image']['name'];  // New image name

                    // Check whether the file is available or not
                    if($image_name!="")
                    {
                        // Image is available
                        // Rename the image
                        $extension=end(explode('.',$image_name)); // Get the extension of the image
                        $image_name="Food-Name-".rand(0000,9999).".".$extension;  // New name of image

                        // Get the source pathe and dest path
                        $src_path=$_FILES['image']['tmp_name'];
                        $dest_path="../images/food/".$image_name;  // Destination path

                        // upload the image
                        $upload_image=move_uploaded_file($src_path,$dest_path);

                        // Check whether the image is uploaded or not
                        if($upload_image==false)
                        {
                            // Failed to upload image
                            $_SESSION['upload_img_failed']='<div class="error">Failed to upload image</div>';
                            header('location:'.SITEURL.'admin/manage-food.php');

                            // Stop the process
                            die();
                        }

                        // remove current image if available
                        if($current_image!="")
                        {
                            // Current image is available
                            // Remove the image
                            $remove_path="../images/food/".$current_image;

                            $remove=unlink($remove_path);

                            // Chech whether image is removed or not
                            if($remove==false)
                            {
                                // Failed to remove image
                                $_SESSION['remove_img_failed']='<div class="error">Failed to remove currrent image</div>';

                                // Redirect to manage food
                                header('location:'.SITEURL.'admin/manage-food.php');

                                // Stop the process
                                die();
                            }
                        }


                    }
                    else
                    {
                        $image_name=$new_food_current_image;
                    }
                }
                else
                {
                    $image_name=$new_food_current_image;
                }


                // Update the food in database
                $update_food_query="UPDATE tbl_food SET 
                                title='$new_food_title',
                                description='$new_food_description',
                                price='$new_food_price',
                                image_name='$image_name',
                                category_id='$new_food_category',
                                featured = '$new_food_featured',
                                active='$new_food_active' 
                                WHERE id=$new_food_id
                ";
                // Execute the query
                $res3=mysqli_query($conn,$update_food_query);
                
                // Check Whether the query is executed or not
                if($res3==true)
                {
                    // Query Executed and food updated
                    $_SESSION['food_updated']='<div class="success">Food updated successfully</div>';

                    // Redirect to manage food
                    header('location:'.SITEURL.'admin/manage-food.php');
                    
                }
                else
                {
                    // Failed to update food
                    $_SESSION['food_update_failed']='<div class="error">Failed to update food</div>';

                    // Redirect to manage food
                    header('location:'.SITEURL.'admin/manage-food.php');
                    
                }

                // Redirect to manage food with session
            }

        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
