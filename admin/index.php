<?php

include('../config/db.php');
include('includes/header.php');
?>

<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Admin</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                $dash_user_query = "SELECT * FROM admins";
                                                $dash_user_query_run = mysqli_query($con, $dash_user_query);

                                                if($category_total = mysqli_num_rows($dash_user_query_run))
                                                {
                                                    echo '<h4 class="mb-0"> '.$category_total.' </h4>';
                                                }
                                                else
                                                {
                                                    echo '<h4 class="mb-0">No Data</h4>';
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        <a href="view_admin.php">View-Detail</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                                 

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total User</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                $dash_user_query = "SELECT * FROM registration";
                                                $dash_user_query_run = mysqli_query($con, $dash_user_query);

                                                if($category_total = mysqli_num_rows($dash_user_query_run))
                                                {
                                                    echo '<h4 class="mb-0"> '.$category_total.' </h4>';
                                                }
                                                else
                                                {
                                                    echo '<h4 class="mb-0">No Data</h4>';
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        <a href="view-register.php">View-Detail</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Product</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                $dash_user_query = "SELECT * FROM products";
                                                $dash_user_query_run = mysqli_query($con, $dash_user_query);

                                                if($category_total = mysqli_num_rows($dash_user_query_run))
                                                {
                                                    echo '<h4 class="mb-0"> '.$category_total.' </h4>';
                                                }
                                                else
                                                {
                                                    echo '<h4 class="mb-0">No Data</h4>';
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        <a href="product-view.php">View-Detail</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Reviews
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    <?php
                                                        $dash_user_query = "SELECT * FROM contact_review";
                                                        $dash_user_query_run = mysqli_query($con, $dash_user_query);

                                                        if($category_total = mysqli_num_rows($dash_user_query_run))
                                                        {
                                                            echo '<h4 class="mb-0"> '.$category_total.' </h4>';
                                                        }
                                                        else
                                                        {
                                                            echo '<h4 class="mb-0">No Data</h4>';
                                                        }
                                                    ?>
                                                    </div>
                                                </div>
                                                <a href="manage-reviews.php">View-Detail</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Order</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                        $dash_user_query = "SELECT * FROM orders";
                                                        $dash_user_query_run = mysqli_query($con, $dash_user_query);

                                                        if($category_total = mysqli_num_rows($dash_user_query_run))
                                                        {
                                                            echo '<h4 class="mb-0"> '.$category_total.' </h4>';
                                                        }
                                                        else
                                                        {
                                                            echo '<h4 class="mb-0">No Data</h4>';
                                                        }
                                                    ?>
                                            </div>
                                        </div>
                                        <a href="manage-order.php">View-Detail</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Fiber</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php
                                                        $dash_user_query = "SELECT * FROM fiber";
                                                        $dash_user_query_run = mysqli_query($con, $dash_user_query);

                                                        if($category_total = mysqli_num_rows($dash_user_query_run))
                                                        {
                                                            echo '<h4 class="mb-0"> '.$category_total.' </h4>';
                                                        }
                                                        else
                                                        {
                                                            echo '<h4 class="mb-0">No Data</h4>';
                                                        }
                                                    ?>
                                            </div>
                                        </div>
                                        <a href="fibermanage.php">View-Detail</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>



                                       
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php
include('includes/footer.php');
include('includes/script.php');
?>
