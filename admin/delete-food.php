<?php
    include('../config/constants.php'); 

// echo Detele food page

if(isset($_GET['id']) && isset($_GET['image_name'])) // Either use && or AND
{
    // Process to delete
    // Get id and image name
    $id=$_GET['id'];
    $image_name=$_GET['image_name'];

    // Remove the image if available
    if($image_name!="")
    {
        // Get the image
        $path="../images/food/".$image_name;

        // Remove image file from folder
        $remove=unlink($path);

        // check whether the image is removed or not 
        if($remove==false)
        {
            // Failed to remove image
            $_SESSION['rem_img_failed']="<div class='error'>Failed to remove image file</div>";

            // Redirect to manage Food
            header('location:'.SITEURL.'admin/manage-food.php');

            // Stop the prodecc of deleting food
            die();
        }
    }
    // Delete food from database

    $delte_food_query="DELETE FROM tbl_food WHERE id=$id";

    // Execute the query
    $res=mysqli_query($conn,$delte_food_query);

    // Check whether the query executed or not
    if($res==true)
    {
        // Food deleted
        $_SESSION['delete_food_success']="<div class='success'>Food deleted successfully</div>";
        header('location:'.SITEURL.'/admin/manage-food.php');
    }
    else
    {
        // Failed to delete food
        $_SESSION['delete_food_failed']="<div class='error'>Failed to delete Food</div>";
        header('location:'.SITEURL.'/admin/manage-food.php');
        
    }

    // Redirect to mange food with session message


}
else
{
    // Redirect to manage Food page
    $_SESSION['delete_food_failed']="<div class='error'>unauthorize Asccess</div>";
    header('location:'.SITEURL.'/admin/manage-food.php');
}
?>