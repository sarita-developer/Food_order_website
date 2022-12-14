<?php  include('Partials/menu.php') ?>

        <!-- Main content Section Start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>MANAGE ADMIN</h1>
                <br><br>

                <?php                    

                    if(isset($_SESSION['order_update']))
                    {
                        echo $_SESSION['order_update'];
                        unset($_SESSION['order_update']);
                    }

                ?>

                <table class="tbl-125">
                    <tr>
                        <th>S.N.</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Ordered Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Customer Contact</th>
                        <th>Customer Email</th>
                        <th>Customer Address</th>
                        <th>Actions</th>

                    </tr>

                    <?php
                    
                        //Get all the details from database
                        $select_order_quety="SELECT * FROM tbl_order ORDER BY id  DESC"; // Display the latest order first

                        // Execute the query
                        $res=mysqli_query($conn,$select_order_quety);

                        // Count the rowa
                        $count=mysqli_num_rows($res);

                        $sn=1;  // Create a serial nimber and set initial

                        // Check whether we have orders or not
                        if($count>1)
                        {
                            // We have orders
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $order_id=$row['id'];
                                $oder_food=$row['food'];
                                $oder_qty=$row['qty'];
                                $oder_price=$row['price'];
                                $oder_total=$row['total'];
                                $oder_order_date=$row['order_date'];
                                $oder_status=$row['status'];  
                                $oder_customer_name=$row['customer_name'];
                                $oder_customer_contact=$row['customer_contact'];
                                $oder_customer_email=$row['customer_email'];
                                $oder_customer_address=$row['customer_address'];

                                ?>

                                    <tr>
                                        <td><?php echo $sn++ ?></td>
                                        <td><?php echo $oder_food ?></td>
                                        <td><?php echo $oder_price ?></td>
                                        <td><?php echo $oder_qty ?></td>
                                        <td><?php echo $oder_total ?></td>
                                        <td><?php echo $oder_order_date ?></td>
                                        <td>
                                        <?php 
                                                // Ordered, On dilivery, delivered, Cancelled
                                                if($oder_status=="Ordered")
                                                {
                                                    echo "<label style='color:purple'>$oder_status</label>";
                                                }
                                                elseif($oder_status=="On Delivery")
                                                {
                                                    echo "<label style='color:orange'>$oder_status</label>";
                                                }
                                                elseif($oder_status=="Delivered")
                                                {
                                                    echo "<label style='color:green'>$oder_status</label>";
                                                }
                                                elseif($oder_status=="Cancelled")
                                                {
                                                    echo "<label style='color:red'>$oder_status</label>";
                                                }
                                            ?>
                                            <!-- <?php echo $oder_status ?> -->
                                        </td>
                                        <td><?php echo $oder_customer_name ?></td>
                                        <td><?php echo $oder_customer_contact ?></td>
                                        <td><?php echo $oder_customer_email ?></td>
                                        <td><?php echo $oder_customer_address ?></td>
                                        

                                        <td>
                                            <a href="<?php echo SITEURL ?>admin/update-order.php?id=<?php echo $order_id; ?>" class="btn-secondary">Update Order</a>
                                        </td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            // We dont have any orders
                            echo "<tr><td colspan='12' class='error'>Order not available</td></tr>";
                        }
                    
                    ?>

                    
                </table>
            </div>
        </div>
        <!-- Main content Section End -->


<?php include('Partials/footer.php') ?>