<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Upadate Categories
                        <a href="categories-view.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?php
                    if(isset($_GET['id']))
                    {
                        $id = $_GET['id'];
                        $categories = "SELECT * FROM categories WHERE id='$id' LIMIT 1";
                        $categories_run = mysqli_query($con, $categories);

                        if(mysqli_num_rows($categories_run) > 0)
                        {
                            $row = mysqli_fetch_array($categories_run);
                            ?>

                            <form action="code.php" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Categories Name</label>
                                        <input type="text" class="form-control" name="category_name" value="<?= $row['category_name'] ?>" id="categoriesname" required>
                                    </div>
                                    
                                    
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" name="categories_update" class="btn btn-primary">Update Categories</button>
                                    </div>
                                </div>
                            </form>

                            <?php
                        }
                        else
                        {
                            ?>
                            <h4>No Record Found</h4>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
include('includes/script.php');
?>