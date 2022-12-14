<?php include ('partials/menu.php');?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
        
            if(isset($_SESSION['upload_food_img_fail']))
            {
                echo $_SESSION['upload_food_img_fail'];
                unset($_SESSION['upload_food_img_fail']);
            }
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">


                <tr>
                    <td>Title</td>
                    <td><input type="text" name="title" placeholder="Title of food"></td>
                </tr>
                
                <tr>
                    <td>Description</td>
                    <td><textarea name="description" cols="14" rows="2" placeholder="Description of food"></textarea></td>
                </tr>
                
                <tr>
                    <td>Price</td>
                    <td><input type="number" name="price"></td>
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
                                        $id=$row['id'];
                                        $title=$row['title'];

                                        ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

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
                        <input type="radio" name="featured" value="yes">Yes
                        <input type="radio" name="featured" value="no">No
                    </td>
                </tr>
                
                
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="yes">Yes
                        <input type="radio" name="active" value="no">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php 

// Check whether the submit butoon is clicked or not
if(isset($_POST['submit']))
{  
    $food_title=$_POST['title'];
    $food_desc=$_POST['description'];
    $food_price=$_POST['price'];
    $category=$_POST['category'];
    //For Radio input, we need to check whether the button is selected or not
    if(isset($_POST['featured']))
    {
        //Get the VAlue from form
        $food_featured = $_POST['featured'];
    }
    else
    {
        //Set the Default VAlue
        $food_featured = "No";
    }

    if(isset($_POST['active']))
    {
        //Get the VAlue from form 
        $food_active = $_POST['active'];
    }
    else
    {
        //Set the Default VAlue
        $food_active = "No";
    }


    // upload the image if selected
    // check whether the select image is clicked or not and upload the image if image is selected
    if(isset($_FILES['image']['name']))
    {
        // get the details of the selected image
        $image_name=$_FILES['image']['name'];

        // check whether the image is selected or not
        if($image_name!="")
        {
            // Image is selected
            // Rename the image
            // get the extension of selected image (jpg, png, jpeg etc)
            $extension=end(explode('.',$image_name));  // divedide the image name into two part ex. sarita.jpg into sarita and jpg

            // create new name for image
            $image_name="Food-Name-".rand(0000,9999).".".$extension; // New image name

            // Source path is the current location of image
            $src=$_FILES['image']['tmp_name'];

            // Destination path for the image to be uploaded
            $dest="../images/food/".$image_name;

            // upload the image
            $upload_img=move_uploaded_file($src,$dest);

            // check whether the image is uploaded or not
            if($upload_img==false)
            {
                // Failed to upload image
                $_SESSION['upload_food_img_fail']='<div class="error">Failed to Upload Image.</div>';   
                header('location:'.SITEURL.'/admin/add-food.php');  // Redirect to Add Food page
                die();
            }
        }
    }
    else
    {
        $image_name=''; // Setting default value as blank
    }

    // SQL to insert the food data in the database table
    $insert_food_query="INSERT INTO tbl_food SET
                        title='$food_title',
                        description='$food_desc',
                        price=$food_price,
                        image_name='$image_name',
                        category_id=$category,
                        featured='$food_featured',
                        active='$food_active'
                    ";

    // execute the query
    $res2=mysqli_query($conn,$insert_food_query);

    // check whether the data is inserted or not
    if($res2==true)
    {
        // // Data inserted successfully
        //$_SESSION['food_added']='<div class="success">Food added successfully.</div>';   
        header('location:'.SITEURL.'/admin/manage-food.php');  // Redirect to Add Food page
        
                
    }
    else
    {
        // // Failed to insert data
        $_SESSION['food_not_added']='<div class="Error">Food not added.</div>';   
        header('location:'.SITEURL.'/admin/manage-food.php');  // Redirect to Add Food page
        
    }
}

?>




<?php include ('partials/footer.php');?>
